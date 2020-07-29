import React, { Component } from "react";
import "./style2.css";
import SideUser from "./VideoComponents/SideUser";
import {
    OffVideo,
    EndCall,
    ReceiveCall
} from "./VideoComponents/VideoElements";

import "@mdi/font/css/materialdesignicons.css";

const webrtc = new RTCPeerConnection({
    iceServers: [
        {
            urls: ["stun:stun.stunprotocol.org", "stun:relay.backups.cz"]
        },
        {
            urls: "turn:relay.backups.cz",
            credential: "webrtc",
            username: "webrtc"
        },
        {
            urls: "turn:relay.backups.cz?transport=tcp",
            credential: "webrtc",
            username: "webrtc"
        }
    ]
});

// const socketUrl = `wss://${location.host}/ws`;
const socketUrl = `ws://localhost:3000/ws`;
const socket = new WebSocket(socketUrl);
const ringer = new Audio("/videocall/Assets/audio/ringtone.mp3");
ringer.loop = true;
var interval;

const activeuser = window.user

class VideoCall extends Component {
    constructor(props) {
        super(props);
        const id = Math.floor(Math.random() * 1000);
        this.state = {
            localvideo: {
                endcall: false,
                pause: false,
                muted: true
            },
            users: [],
            mydetails: activeuser || {
                name: "User - " + id,
                id: id,
                image: null,
                status: 0,
                room: "conference-room"
            },
            call: {
                isRinging: false,
                caller: {}
            },
            currentuser: null,
            otherPerson: null,
            muteremote: true
        };
        this.localVideo = null;
        this.remoteVideo = null;
    }

    stopStream() {
        // if (!this.localVideo)
        this.localVideo.pause();
        // if (!this.remoteVideo)
        this.remoteVideo.pause();
    }

    componentDidMount() {
        try {
            this.startLocalStream();
        } catch (e) {
            console.log("ERROR IN LOCALVIDEO STREAM");
        }
        try {
            this.initWebrtc();
        } catch (e) {
            console.log("ERROR IN WEBRTC");
        }
        try {
            this.initSocket();
        } catch (e) {
            console.log("ERROR IN SOCKET");
        }
    }

    async handControlBtn(state) {
        let local = this.state.localvideo;
        local[state] = !local[state];
        this.setState({ localvideo: local }, async () => {
            if (state == "pause") {
                local["muted"] = true;
                this.setState({ localvideo: local });
                if (this.state.localvideo.pause) {
                    this.localVideo.pause();
                    // REMOVE STREAM & SEND SIGNAL FOR PAUSE
                    await this.pauseRemoteVideo(
                        true,
                        this.state.localvideo.muted
                    );
                } else {
                    this.localVideo.play();
                    await this.pauseRemoteVideo(
                        false,
                        this.state.localvideo.muted,
                        false
                    );
                }
            }
            if (state == "muted") {
                await this.pauseRemoteVideo(
                    this.state.localvideo.pause,
                    this.state.localvideo.muted,
                    false
                );
            }
            if (state == "endcall") {
                this.stopStream();
                await this.pauseRemoteVideo(true, true, true);
            }
        });
    }

    async pauseRemoteVideo(video, audio, ended) {
        if (this.state.otherPerson != null) {
            this.sendMessageToSignallingServer({
                channel: "pause_play",
                video: video,
                audio: audio,
                ended: ended,
                otherPerson: this.state.otherPerson
            });
        }
    }

    startCall(index, user) {
        let users = this.state.users;
        users[index].status = 1;
        this.setState({ users: users, currentuser: index }, () => {
            this.sendMessageToSignallingServer({
                channel: "start_call",
                otherPerson: user.id
            });
        });
    }

    getCurrentUser(index) {
        return (index !== null && this.state.users[index]) || {};
    }

    getUserWithID(id) {
        const users = this.state.users;
        let search = {};
        users.forEach(user => {
            if (user.id == id) {
                search = user;
            }
        });
        return search;
    }

    endcall(index) {
        let users = this.state.users;
        users[index].status = 0;
        this.setState({ users });
    }

    updateActiveUsers(users, member) {
        let members = [];
        users.forEach(user => {
            if (user.data.id !== this.state.mydetails.id)
                members.push(user.data);

            if (user.data.id == member.id) {
                user.data.status = 3;
            }
        });
        this.setState({ users: members });
    }

    updateUserAccepted(member) {
        const users = this.state.users;
        let localvideo = this.state.localvideo;
        let members = [];
        users.forEach(user => {
            if (user.id == member.otherPerson) {
                user.status = 2;
                localvideo.endcall = false;
            }
            members.push(user);
        });
        this.setState({ users: members, localvideo });
    }

    removeUserIfNotRemoved(users, memberdata) {
        let data = [];
        users.forEach(user => {
            if (!user.data.id == memberdata.id) {
                data.push(user.data);
            }
        });
        return data;
    }

    processCustomSocket(message) {
        switch (message.action) {
            case "joined":
                this.updateActiveUsers(message.users, message.memberdata);
                break;
            case "left":
                this.updateActiveUsers(
                    this.removeUserIfNotRemoved(
                        message.users,
                        message.memberdata
                    ),
                    message.memberdata
                );
                break;
            case "endcall":
                this.updateEndCall(
                    this.removeUserIfNotRemoved(
                        message.users,
                        message.memberdata
                    ),
                    message.memberdata
                );
                break;
            default:
                break;
        }
    }

    updateEndCall(newusers, member) {
        let users = [];
        newusers.forEach(user => {
            if (user.data.id == member.id) {
                user.data.status = 3;
            }
            users.push(user.data);
        });

        let localvideo = this.state.localvideo;
        localvideo.endcall = true;
        this.setState({ users, localvideo });
    }

    initWebrtc() {
        webrtc.addEventListener("icecandidate", event => {
            if (!event.candidate) {
                return;
            }

            this.sendMessageToSignallingServer({
                channel: "webrtc_ice_candidate",
                candidate: event.candidate,
                otherPerson: this.state.otherPerson
            });
        });

        webrtc.addEventListener("track", event => {
            /** @type {HTMLVideoElement} */
            const remoteVideo = document.getElementById("remote-video");
            this.remoteVideo = remoteVideo;
            remoteVideo.srcObject = event.streams[0];
        });
    }

    startLocalStream() {
        this.localVideo = document.getElementById("local-video");
        window.navigator.mediaDevices
            .getUserMedia({ video: true, audio: true })
            .then(localStream => {
                /** @type {HTMLVideoElement} */
                this.localVideo.srcObject = localStream;
                for (const track of localStream.getTracks()) {
                    webrtc.addTrack(track, localStream);
                }
            });
    }

    initSocket() {
        // log in directly after the socket was opened
        socket.addEventListener("open", () => {
            console.log("websocket connected");
            this.sendMessageToSignallingServer({
                channel: "login",
                name: this.state.mydetails.id,
                data: this.state.mydetails,
                room: this.state.mydetails.room
            });
        });

        socket.addEventListener("message", event => {
            const message = JSON.parse(event.data.toString());
            this.handleMessage(message);
        });

        socket.addEventListener("disconnected", event => {
            alert("Disconnected");
        });
    }

    /**
     * Sends the message over the socket.
     * @param {WebSocketMessage} message The message to send
     */
    sendMessageToSignallingServer(message) {
        const json = JSON.stringify(message);
        socket.send(json);
    }

    /**
     * Processes the incoming message.
     * @param {WebSocketMessage} message The incoming message
     */
    async handleMessage(message) {
        let otherPerson = message.otherPerson;
        let members = [];
        if (otherPerson == null) {
            otherPerson = this.state.otherPerson;
        } else {
            this.setState({ otherPerson: message.otherPerson });
        }
        switch (message.channel) {
            case "start_call":
                console.log(`receiving call from ${message}`);

                this.setState(
                    {
                        call: {
                            isRinging: true,
                            caller: message.otherPerson,
                            message
                        }
                    },
                    () => {
                        ringer.play();

                        let timer = 0;
                        interval = setInterval(() => {
                            if (timer >= 30) {
                                ringer.pause();
                                this.setState(
                                    {
                                        call: {
                                            isRinging: false,
                                            caller: null,
                                            message: {}
                                        }
                                    },
                                    () => {
                                        // receiver did not answer
                                        this.sendMessageToSignallingServer({
                                            channel: "noanswer",
                                            otherPerson: this.state.otherPerson
                                        });
                                        clearInterval(interval);
                                    }
                                );
                            }
                            timer++;
                        }, 1000);
                    }
                );
                break;

            case "webrtc_ice_candidate":
                console.log("received ice candidate");
                console.log(message);
                await webrtc.addIceCandidate(message.candidate);
                break;

            case "call_accepted":
                console.log("Call accepted");
                console.log(message);
                this.updateUserAccepted(message);
                break;

            case "webrtc_offer":
                console.log("received webrtc offer");
                await webrtc.setRemoteDescription(message.offer);
                const answer = await webrtc.createAnswer();
                await webrtc.setLocalDescription(answer);

                this.sendMessageToSignallingServer({
                    channel: "webrtc_answer",
                    answer,
                    otherPerson
                });

                break;

            case "webrtc_answer":
                console.log(
                    "received webrtc answer: -- " + message.otherPerson
                );
                webrtc.setRemoteDescription(message.answer);
                this.sendMessageToSignallingServer({
                    channel: "call_accepted",
                    otherPerson: otherPerson
                });
                this.updateUserAccepted(message);
                break;
            case "pause_play":
                if (message.video) {
                    this.remoteVideo.pause();
                } else {
                    this.remoteVideo.play();
                }
                this.setState({ muteremote: message.audio });
                console.log(message);
                break;
            case "rejected":
                this.state.users.forEach(user => {
                    if (user.id == otherPerson) {
                        user.status = 4;
                    }
                    members.push(user);
                });
                this.setState({ users: members });
                break;
            case "noanswer":
                this.state.users.forEach(user => {
                    if (user.id == otherPerson) {
                        user.status = 5;
                    }
                    members.push(user);
                });
                this.setState({ users: members });
                break;
            default:
                console.log("unknown message", message);
                this.processCustomSocket(message);
                break;
        }
    }

    async handleAcceptIncommingCall() {
        let call = this.state.call;
        call.isRinging = false;
        ringer.pause();
        this.setState({ call }, async () => {
            clearInterval(interval);

                const offer = await webrtc.createOffer();
                await webrtc.setLocalDescription(offer);
                this.sendMessageToSignallingServer({
                    channel: "webrtc_offer",
                    offer,
                    otherPerson: this.state.otherPerson
                });

        });
    }

    async handleEndCall() {
        // await webrtc.removeStream(this.localVideo.srcObject);
        // await webrtc.removeStream(this.remoteVideo.srcObject);
        let localvideo = this.state.localvideo;
        localvideo.endcall = true;
        this.setState({ localvideo }, async () => {
            this.sendMessageToSignallingServer({
                channel: "end_call",
                otherPerson: this.state.otherPerson
            });
            window.location = "/video/call/home";
        });
    }

    async handleRejectCall() {
        ringer.pause();
        clearInterval(interval);
        this.sendMessageToSignallingServer({
            channel: "rejected",
            otherPerson: this.state.otherPerson
        });
        this.setState({
            call: {
                isRinging: false,
                caller: null,
                message: {}
            }
        });
    }

    render() {
        const { localvideo, users } = this.state;
        const { account_type } = this.props;
        return (
            <>
                <div id="loader-wrapper">
                    <div id="loader"></div>
                </div>
                <div id="wrapper">
                    <h2 className="col-md-10 title">
                        Metis Technologies Video Conference
                    </h2>
                    <div className="col-md-10 main-box remote-video-box">
                        <div className="row">
                            <div className="col-md-3 left-side">
                                <SideUser
                                    users={users}
                                    parent={this}
                                    role={account_type}
                                />
                            </div>

                            <div className="col-md-9" style={{ padding: 0 }}>
                                <div className="local-video-box">
                                    <h5 className="caller-info">
                                        {this.state.mydetails.name} (You)
                                    </h5>
                                    <video
                                        className="video-play"
                                        id="local-video"
                                        muted={localvideo.muted}
                                        autoPlay
                                    ></video>
                                    {(localvideo.endcall && (
                                        <EndCall
                                            ended={localvideo.endcall}
                                            type={2}
                                            role={account_type}
                                        />
                                    )) || (
                                        <OffVideo
                                            pause={localvideo.pause}
                                            muted={localvideo.muted}
                                        />
                                    )}
                                </div>

                                <h5 className="caller-info">
                                    {
                                        this.getCurrentUser(
                                            this.state.currentuser
                                        ).name
                                    }
                                </h5>
                                <video
                                    className="video-play"
                                    id="remote-video"
                                    autoPlay
                                    muted={this.state.muteremote}
                                ></video>
                                {localvideo.endcall && (
                                    <EndCall
                                        ended={localvideo.endcall}
                                        type={1}
                                        role={account_type}
                                    />
                                )}
                                <ReceiveCall
                                    isRinging={this.state.call.isRinging}
                                    caller={this.state.call.caller}
                                    parent={this}
                                />
                                <div className="overlay"></div>
                                <div className="controls">
                                    <a
                                        href="#"
                                        class={`button ${
                                            localvideo.pause
                                                ? "primaryactive"
                                                : "primary"
                                        }`}
                                        onClick={e => {
                                            e.preventDefault();
                                            this.handControlBtn("pause");
                                        }}
                                    >
                                        <i className="mdi mdi-camera-off"></i>{" "}
                                    </a>
                                    <a
                                        href="#"
                                        class={`button ${
                                            localvideo.endcall
                                                ? "dangeractive"
                                                : "danger"
                                        }`}
                                        onClick={e => {
                                            e.preventDefault();
                                            this.handleEndCall();
                                        }}
                                    >
                                        <i className="mdi mdi-phone-hangup"></i>{" "}
                                    </a>
                                    <a
                                        href="#"
                                        class={`button ${
                                            localvideo.muted
                                                ? "primaryactive"
                                                : "primary"
                                        }`}
                                        onClick={e => {
                                            e.preventDefault();
                                            this.handControlBtn("muted");
                                        }}
                                    >
                                        <i className="mdi mdi-microphone-off"></i>{" "}
                                    </a>
                                </div>
                                <div className="overlay"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {/* <audio
                    style={{ display: "none" }}
                    id="ringer"
                    src=""
                    controls
                    autoPlay
                /> */}
            </>
        );
    }
}

export default VideoCall;
