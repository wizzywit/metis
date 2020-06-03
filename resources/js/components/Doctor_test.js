import React, { Component} from 'react';
import Pusher from 'pusher-js';
import MediaHandler from '../MediaHandler';

const APP_KEY = '52b6df945610aa082478';

class Doctor_test extends Component {
    constructor() {
        super();


        this.state = {
            hasMedia: false,
            otherUserId: null
        }

        this.user = window.user;
        this.user.stream = null;
        this.usersOnline;
        this.users = [];
        this.caller;


        this.mediaHandler = new MediaHandler();
        this.setupPusher();
        //To iron over browser implementation anomalies like prefixes
        this.GetRTCPeerConnection();
        this.GetRTCSessionDescription();
        this.GetRTCIceCandidate();
        //prepare the caller to use peerconnection
        this.prepareCaller();

        this.setupPusher = this.setupPusher.bind(this);
        this.GetRTCPeerConnection = this.GetRTCPeerConnection.bind(this);
        this.GetRTCSessionDescription = this.GetRTCSessionDescription.bind(this);
        this.GetRTCIceCandidate = this.GetRTCIceCandidate.bind(this);
        this.prepareCaller = this.prepareCaller.bind(this);

    }

    componentWillMount() {
        this.mediaHandler.getPermissions()
        .then((stream) => {
            this.setState({hasMedia: true});
            this.user.stream = stream;
            try {
                this.myVideo.srcObject = stream;
            } catch (e) {
                this.myVideo.src = URL.createObjectURL(stream);
            }

            this.myVideo.play();
        })
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
                this.users.push(member.id);
              }
            });

          });

        this.channel.bind("pusher:member_added", member => {
            this.users.push(member.id);
        });

        channel.bind("pusher:member_removed", member => {
        // for remove member from list:
            var index = users.indexOf(member.id);
            users.splice(index, 1);
            if (member.id == room) {
                endCall();
            }
        });

        this.channel.bind(`client-signal-${this.user.id}`, (signal)=> {

        })
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
      //Listen for ICE Candidates and send them to remote peers
      this.caller.onicecandidate = function(evt) {
        if (!evt.candidate) return;
        console.log("onicecandidate called");
        this.onIceCandidate(caller, evt);
      };
      //onaddstream handler to receive remote feed and show in remoteview video element
      this.caller.onaddstream = function(evt) {
        console.log("onaddstream called");
        try {
            this.userVideo.src = URL.createObjectURL(stream);
        } catch (e) {
            this.userVideo.srcObject = stream;
        }
      };
    }


    render() {
        return (
            <div className="Doctor">
                <div className="row-fluid">
                    <div className="span4 offset-3">
                        {this.users.map((user_id) => {
                            return <button className="btn btn-success justify-content-center" onClick={() => this.callTo(user_id)}>Call Patient</button>
                        })}
                    </div>
                </div>
                <br/>
                <br/>
                <div className="video-container">
                    <video className="my-video" ref={(ref)=> {this.myVideo = ref;}} autoPlay muted></video>
                    <video className="user-video" ref={(ref)=> {this.userVideo = ref;}} autoPlay></video>
                </div>
                <div className="row-fluid">
                    <div className="span4 offset-3">
                        <button className="btn btn-success justify-content-center" onClick={() => this.callTo(this.user.patient_id)}>Call {this.user.patient_name}</button>
                    </div>
                </div>
            </div>
        );
    }
}



