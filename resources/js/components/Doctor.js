import React, { Component} from 'react';
import Pusher from 'pusher-js';
import BlockUi from 'react-block-ui';
import 'react-block-ui/style.css';
import Swal from 'sweetalert2';
var freeice = require('freeice');


const APP_KEY = '52b6df945610aa082478';

class Doctor extends Component {
    constructor() {
        super();

        this.state = {
            users: [],
            button: "none",
            blocking: false,
            room: undefined,
            awaiting: true
        };
        this.user = window.user;
        this.usersOnline;
        this.caller;
        this.localUserMedia = null;
        this.sessionDesc;
        // this.config = {
        //     'iceServers': [
        //         {
        //             'url': 'stun:stun.l.google.com:19302'
        //         },
        //         {
        //             'url': 'turn:numb.viagenie.ca',
        //             'credential': 'Jesuschrist01',
        //             'username': 'wisdompraise968@gmail.com'
        //         },
        //     ]
        // };

        this.config = {
            'iceServers': [
                {
                    'url': 'stun:127.0.0.1:4040'
                }
            ]
        };

        this.mediaHandler;

        //To iron over browser implementation anomalies like prefixes
        this.GetRTCPeerConnection();
        this.GetRTCSessionDescription();
        this.GetRTCIceCandidate();
        //prepare the caller to use peerconnection
        this.prepareCaller();
        this.setupPusher();

        this.setupPusher = this.setupPusher.bind(this);
        this.GetRTCPeerConnection = this.GetRTCPeerConnection.bind(this);
        this.GetRTCSessionDescription = this.GetRTCSessionDescription.bind(this);
        this.GetRTCIceCandidate = this.GetRTCIceCandidate.bind(this);
        this.prepareCaller = this.prepareCaller.bind(this);

    }

    setupPusher() {
        Pusher.logToConsole=true;
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

        this.channel = this.pusher.subscribe('presence-'+this.user.channel);
        this.channel.bind("pusher:subscription_succeeded", members => {
            //set the member count
            this.usersOnline = members.count;
            members.each(member => {
              if (member.id != this.user.id) {
                let index = this.state.users.indexOf(member.id);
                if(index === -1){
                    var joined = this.state.users.concat(member.id);
                    this.setState({ users: joined, awaiting: false });
                }
              }
            });
          });

        this.channel.bind("pusher:member_added", member => {
            let index = this.state.users.indexOf(member.id);
                if(index == -1){
                    var joined = this.state.users.concat(member.id);
                    this.setState({ users: joined, awaiting: false });
                }
        });

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

        this.channel.bind("client-candidate", (msg) => {
            if(msg.room == this.state.room ){
                console.log("candidate received");
                this.caller.addIceCandidate(new RTCIceCandidate(msg.candidate));
            }
        });

        this.channel.bind("client-answer", (answer) => {
            if (answer.room == this.state.room) {
              console.log("answer received");
              this.caller.setRemoteDescription(new RTCSessionDescription(answer.sdp));
              console.log("Patient SDP: "+new RTCSessionDescription(answer.sdp));
              this.setState({blocking: false});
            }
          });

          this.channel.bind("client-reject", (answer) => {
            if (answer.room == this.state.room) {
              console.log("Call declined");
              Swal.fire({
                title: 'Feedback!',
                text: "Call to " + answer.rejected + " was politely declined",
                icon: 'info',
                confirmButtonText: 'Ok'
              });
              this.setState({blocking: false});
              this.endCall();
            }
          });

          this.channel.bind("client-endcall", (answer) => {
            if (answer.room == this.state.room) {
              console.log("Call Ended");
              this.endCall();
            }
          });


    }


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
        console.log("STREAM: "+evt.stream);
        try {
            this.userVideo.src = URL.createObjectURL(evt.stream);
        } catch (e) {
            this.userVideo.srcObject = evt.stream;
        }
      };
    }

    getCam() {
        //Get local audio/video feed and show it in selfview video element
        return navigator.mediaDevices.getUserMedia({
          video: true,
          audio: true
        });
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



     //Create and send offer to remote peer on button click
     callUser(user_id) {
        this.setState({blocking: true});
        this.getCam()
        .then(stream => {
            this.localUserMedia = stream;
            this.toggleEndCallButton();
            try {
                this.myVideo.srcObject = stream;
            } catch (e) {
                this.myVideo.src = URL.createObjectURL(stream);
            }
            stream.getTracks().forEach(track => {
                this.caller.addTrack(track, stream);
            });

            this.caller.createOffer().then((desc) => {
                console.log(desc);
                return this.caller.setLocalDescription(new RTCSessionDescription(desc));
            })
            .then(() => {
                this.channel.trigger(`client-signal-${user_id}`, {
                    sdp: this.caller.localDescription,
                    room: user_id,
                    from: this.user.name,
                  });
                  this.setState({room: user_id});
            })
            .catch((error) => {
                console.log("an error occured", error);
              });

          })
          .catch(error => {
            console.log("an error occured", error);
          });
      }
      toggleEndCallButton() {
        if (this.state.button == "none") {
          this.setState({button: "flex"});
        } else {
            this.setState({button: "none"});
        }
      }
    endCall() {
    this.setState({room: undefined});
    this.caller.close();
    for (let track of this.localUserMedia.getTracks()) {
        track.stop();
    }
    this.prepareCaller();
    this.toggleEndCallButton();
    }

    endCurrentCall() {
    this.channel.trigger("client-endcall", {
        room: this.state.room
    });

    this.endCall();
    }


    render() {
        return (
            <BlockUi tag="div" blocking={this.state.awaiting} message="Awaiting Patient, Please wait..">
            <div className="container" style={{marginTop: '10%'}}>
                <BlockUi tag="div" blocking={this.state.blocking} message="Awaiting Patient Pickup">
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
                                <div style={{textAlign: "center"}}>
                                {this.state.users.map((user_id) => {
                                        if(this.state.room == undefined){
                                        return <button key={user_id} className="btn btn-success btn-lg button" style={{ marginRight: "20px"}} onClick={() => this.callUser(user_id)}><i className="fa fa-phone" aria-hidden="true"></i> Call {this.user.patient_name}</button>
                                        }
                                    })}
                                </div>
                        </div>
                    </div>
                </BlockUi>
            </div>

            </BlockUi>

        );
    }
}

export default Doctor;
