import React, { Component} from 'react';
import Pusher from 'pusher-js';
import MediaHandler from '../MediaHandler';

const APP_KEY = '52b6df945610aa082478';

class Patient extends Component {
    constructor() {
        super();

        this.state = {
            users: [],
            button: "none",
        };
        this.user = window.user;
        this.usersOnline;
        this.caller;
        this.localUserMedia = null;
        this.sessionDesc;
        this.room;


        this.mediaHandler = new MediaHandler();

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
                var joined = this.state.users.concat(member.id);
                this.setState({ users: joined });
              }
            });
          });

        this.channel.bind("pusher:member_added", member => {
            var joined = this.state.users.concat(member.id);
            this.setState({ users: joined });
        });

        this.channel.bind("pusher:member_removed", member => {
        // for remove member from list:
            let index = this.state.users.indexOf(member.id);
            this.setState(state => {
                const users = state.users.filter((user, j) => index !== j);
                return {
                  users,
                };
              });
            if (member.id == this.room) {
                this.endCall();
            }
        });

        this.channel.bind("client-candidate", (msg) => {
            if(msg.room == this.room ){
                console.log("candidate received");
                this.caller.addIceCandidate(new RTCIceCandidate(msg.candidate));
            }
        });

        this.channel.bind(`client-signal-${this.user.id}`, (msg)=> {
            if(msg.room == this.user.id){
                let answer = confirm("You have a call from: "+ msg.from + "Would you like to answer?");
                if(!answer){
                    return channel.trigger("client-reject", {"room": msg.room, "rejected":this.user.id});
                }
                this.room = msg.room;
                this.mediaHandler.getPermissions()
                .then(stream => {
                    this.localUserMedia = stream;
                    this.toggleEndCallButton();
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
                            "room": this.room
                        });
                    });

                })
                .catch(error => {
                    console.log('an error occured', error);
                })
            }
        });

        this.channel.bind("client-answer", (answer) => {
            if (answer.room == this.room) {
              console.log("answer received");
              this.caller.setRemoteDescription(new RTCSessionDescription(answer.sdp));
            }
          });

          this.channel.bind("client-reject", (answer) => {
            if (answer.room == this.room) {
              console.log("Call declined");
              alert("call to " + answer.rejected + "was politely declined");
              this.endCall();
            }
          });

          this.channel.bind("client-endcall", (answer) => {
            if (answer.room == this.room) {
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

      this.caller = new window.RTCPeerConnection();
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
                "room": this.room
            });
        }
    }



     //Create and send offer to remote peer on button click
     callUser(user_id) {
        this.mediaHandler.getPermissions()
        .then(stream => {
            this.localUserMedia = stream;
            this.toggleEndCallButton();
            try {
                this.myVideo.srcObject = stream;
            } catch (e) {
                this.myVideo.src = URL.createObjectURL(stream);
            }
            this.toggleEndCallButton();
            this.prepareCaller();
            stream.getTracks().forEach(track => {
                this.caller.addTrack(track, stream);
            });
            this.caller.createOffer().then((desc) => {
                console.log(desc);
                return this.caller.setLocalDescription(desc);
            })
            .then(() => {
                this.channel.trigger(`client-signal-${user_id}`, {
                    sdp: this.caller.localDescription,
                    room: user_id,
                    from: this.user.id,
                  });
                  this.room = user_id;
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
          this.setState({button: "block"});
        } else {
            this.setState({button: "none"});
        }
      }


    endCall() {
    this.room = undefined;
    this.caller.close();
    for (let track of this.localUserMedia.getTracks()) {
        track.stop();
    }
    this.prepareCaller();
    this.toggleEndCallButton();
    }

    endCurrentCall() {
    channel.trigger("client-endcall", {
        room: this.room
    });

    this.endCall();
    }


    render() {
        return (
            <div className="">
                <div className="video-container">
                    <video className="my-video" ref={(ref)=> {this.myVideo = ref;}} autoPlay muted></video>
                    <video className="user-video" ref={(ref)=> {this.userVideo = ref;}} autoPlay></video>
                </div>
                <div className="row-fluid">
                    <div className="span4 offset-3">
                        <button className="btn btn-success justify-content-center" style={{display: this.state.button}} onClick={() => this.endCurrentCall()}>End Call</button>
                    </div>
                </div>
            </div>
        );
    }
}

export default Patient;
