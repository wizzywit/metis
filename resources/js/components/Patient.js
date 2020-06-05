import React, { Component} from 'react';
import Pusher from 'pusher-js';
import Swal from 'sweetalert2'
import BlockUi from 'react-block-ui';

//APP_Key for pusher configuration
const APP_KEY = '52b6df945610aa082478';

class Patient extends Component {
    constructor() {
        super();

        this.state = {
            users: [],
            button: "none",
            room: undefined,
            blocking: true,
        };
        this.user = window.user;
        this.usersOnline;
        this.caller;
        this.localUserMedia = null;
        this.sessionDesc;
        this.config = {
            'iceServers': [
                {
                    'url':'stun:stun.l.google.com:19302'
                },
                {
                    'url': 'turn:numb.viagenie.ca',
                    'credential': 'Jesuschrist01',
                    'username': 'wisdompraise968@gmail.com'

                }
            ]
        };



        this.mediaHandler;

        //To iron over browser implementation anomalies like prefixes
        this.GetRTCPeerConnection();
        this.GetRTCSessionDescription();
        this.GetRTCIceCandidate();

        //prepare the caller to use peerconnection to anable live conferencing
        this.prepareCaller();

        //setup pusher for webRTC signaling
        this.setupPusher();


        //bind all methods to this instace of class
        this.setupPusher = this.setupPusher.bind(this);
        this.GetRTCPeerConnection = this.GetRTCPeerConnection.bind(this);
        this.GetRTCSessionDescription = this.GetRTCSessionDescription.bind(this);
        this.GetRTCIceCandidate = this.GetRTCIceCandidate.bind(this);
        this.prepareCaller = this.prepareCaller.bind(this);

    }

    //pusher setup method
    setupPusher() {
        // Pusher.logToConsole=true;

        //Instantiate Pusher Object
        this.pusher = new Pusher(APP_KEY, {
            authEndpoint: '/pusher/auth',
            cluster: 'ap2',
            auth: {
                params: this.user.id,
                headers: {
                    'X-CSRF-Token': window.csrfToken
                }
            }
        });


        //Subscribe the user to a channel making sure the 'presence-' is used to anable signaling
        this.channel = this.pusher.subscribe('presence-'+this.user.channel);

        //binding channel to various pusher events emitted
        this.channel.bind("pusher:subscription_succeeded", members => {
            //set the member count
            this.usersOnline = members.count;
            members.each(member => {
              if (member.id != this.user.id) {
                var joined = this.state.users.concat(member.id);
                this.setState({ users: joined });
              }
            });
          });


        //callback function to fire when member is removed from the channel
        this.channel.bind("pusher:member_added", member => {
            var joined = this.state.users.concat(member.id);
            this.setState({ users: joined });
        });


        //callback fired when member is removed from the channel
        this.channel.bind("pusher:member_removed", member => {
        // for remove member from list:
            let array = [...this.state.users]; // make a separate copy of the array
            let index = array.indexOf(member.id);
            if (index !== -1) {
                array.splice(index, 1);
                this.setState({users: array});
            }
            if (member.id == this.state.room) {
                this.endCall();
            }
        });

        //callback fired when candidate is recieved and added to ICE candidate for peer communication
        this.channel.bind("client-candidate", (msg) => {
            if(msg.room == this.state.room ){
                console.log("candidate received");
                this.caller.addIceCandidate(new RTCIceCandidate(msg.candidate));
            }
        });

        //callback fired when communication signal is received for video call
        //get cam permissions, then add stream to localUsermedia and toggle end call button,
        //after which the present user stream is added to his video element and to the peer stream, then
        //an answer is sent to the remote peer, and trigering the signal.
        this.channel.bind(`client-signal-${this.user.id}`, (msg)=> {
            if(msg.room == this.user.id){
                Swal.fire({
                    title: 'Hello',
                    text: 'You have a call from: Dr. '+ msg.from + ' Would you like to answer?"',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Decline',
                    confirmButtonText: 'Accept!'
                 }).then((result) => {
                    if(result.value){
                        this.state.room = msg.room;
                        this.getCam()
                        .then(stream => {
                            this.localUserMedia = stream;
                            this.toggleEndCallButton();
                            this.setState({blocking: false});
                            try {
                                this.myVideo.srcObject = stream;
                            } catch (e) {
                                this.myVideo.src = URL.createObjectURL(stream);
                            }
                            this.caller.addStream(stream);
                            let sessionDesc = new RTCSessionDescription(msg.sdp);
                            this.caller.setRemoteDescription(sessionDesc);
                            this.caller.createAnswer().then((sdp) => {
                                this.caller.setLocalDescription(new RTCSessionDescription(sdp));
                                this.channel.trigger("client-answer", {
                                    "sdp": sdp,
                                    "room": this.state.room
                                });
                            });

                        })
                        .catch(error => {
                            console.log('an error occured', error);
                        })
                   }
                   if(!result.value){
                    return this.channel.trigger("client-reject", {"room": msg.room, "rejected":this.user.name});
                    }
                 });
            }
        });

        //callback for when remote user answers call signal, Remote Descrption is set
        this.channel.bind("client-answer", (answer) => {
            if (answer.room == this.state.room) {
              console.log("answer received");
              this.caller.setRemoteDescription(new RTCSessionDescription(answer.sdp));
            }
          });

          //callback to fire when remote endcall is fired
          this.channel.bind("client-endcall", (answer) => {
            if (answer.room == this.state.room) {
              console.log("Call Ended");
              this.endCall();
            }
          });
    }

    //method for camera permission
    getCam() {
        //Get local audio/video feed and show it in selfview video element
        return navigator.mediaDevices.getUserMedia({
          video: true,
          audio: true
        });
      }


     /*
      Different required Methods for peer connections
     */
     GetRTCIceCandidate() {
      window.RTCIceCandidate = window.RTCIceCandidate || window.webkitRTCIceCandidate || window.mozRTCIceCandidate || window.msRTCIceCandidate;
      return window.RTCIceCandidate;
    }

     GetRTCPeerConnection() {
      window.RTCPeerConnection = window.RTCPeerConnection || window.webkitRTCPeerConnection || window.mozRTCPeerConnection || window.msRTCPeerConnection;
      return window.RTCPeerConnection;
    }

    GetRTCSessionDescription() {
      window.RTCSessionDescription = window.RTCSessionDescription || window.webkitRTCSessionDescription ||  window.mozRTCSessionDescription || window.msRTCSessionDescription;
      return window.RTCSessionDescription;
    }

    /* End of required methods
    */


    //method to prepare peer caller(both clients)
    prepareCaller() {
      //Initializing a peer connection

      this.caller = new window.RTCPeerConnection(this.config);
      console.log(this.caller);
      //Listen for ICE Candidates and send them to remote peers
      this.caller.onicecandidate = (evt) => {
        if (!evt.candidate) return;
        console.log("onicecandidate called");
        this.onIceCandidate(this.caller, evt);
      };
      //onaddstream handler to receive remote feed and show in remoteview video element
      this.caller.onaddstream = (evt) => {
        console.log("onaddstream called");
        try {
            this.userVideo.src = URL.createObjectURL(evt.stream);
        } catch (e) {
            this.userVideo.srcObject = evt.stream;
        }
      };
    }


     //Send the ICE Candidate to the remote peer
     onIceCandidate(peer, evt) {
        if (evt.candidate) {
            this.channel.trigger("client-candidate", {
                "candidate": evt.candidate,
                "room": this.state.room
            });
        }
    }


    //toggle endcall button method
    toggleEndCallButton() {
        if (this.state.button == "none") {
          this.setState({button: "flex"});
        } else {
            this.setState({button: "none"});
        }
      }


    //method for end call definition
    endCall() {
    this.setState({room: undefined});
    this.caller.close();
    for (let track of this.localUserMedia.getTracks()) {
        track.stop();
    }
    this.prepareCaller();
    this.toggleEndCallButton();
    }


    //method for end current call
    endCurrentCall() {
    this.channel.trigger("client-endcall", {
        room: this.state.room
    });

    this.endCall();
    }


    render() {
        return (
            <div className="container">
                <BlockUi tag="div" blocking={this.state.blocking} message="Awaiting Doctor's Call, Please wait">
                    <div className="row">
                        <div className="col-xl-7">
                                <div className="video-container">
                                    <video className="my-video" ref={(ref)=> {this.myVideo = ref;}} autoPlay muted></video>
                                    <video className="user-video" ref={(ref)=> {this.userVideo = ref;}} autoPlay></video>
                                    <i title="End Call" style={{display: this.state.button}} onClick={() => this.endCurrentCall()} className="end-button fa fa-phone flex" aria-hidden="true"></i>
                                </div>
                        </div>
                        <div className="col-xl-5 call_button">
                            <h3 style={{textAlign: "center"}} >Welcome To Metis Conference</h3>
                        </div>
                    </div>
                </BlockUi>
            </div>
        );
    }
}

export default Patient;
