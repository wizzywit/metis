// import WebCaller from "./webcaller.js";

const webrtc = new RTCPeerConnection({
    iceServers: [
        {
            urls: ["stun:stun.stunprotocol.org", "stun:relay.backups.cz"]
        },
        {
            url: "turn:relay.backups.cz",
            credential: "webrtc",
            username: "webrtc"
        },
        {
            url: "turn:relay.backups.cz?transport=tcp",
            credential: "webrtc",
            username: "webrtc"
        }
    ]
});

// const socketUrl = `ws://${location.host}/ws`;
const socketUrl = `ws://localhost:3000/ws`;
const socket = new WebSocket(socketUrl);
this.ringer = new Audio("../videocall/Assets/audio/ringtone.mp3");
this.ringer.loop = true;
this.interval;

const offcamera = document.getElementById("offcamera");
const hangup = document.getElementById("hangup");
const offmicrophone = document.getElementById("offmicrophone");

let localVideo = document.getElementById("local-video");
let remoteVideo = document.getElementById("remote-video");
this.onlineusers = document.getElementById("online-users");
this.localusername = document.getElementById("local-username");
this.ringerui = document.getElementById("ringer-ui");
this.rejectcall = document.getElementById("ringer-reject-call");
this.acceptcall = document.getElementById("ringer-accept-call");

const id = Math.floor(Math.random() * 1000);
// USERS & USERNAM
this.mydetails = {
    name: "User - " + id,
    id: id,
    image: null,
    status: 0
};

this.otherPerson = null;
this.users = [];

// INITIALIZE LOCAL VIDEO STREAM
window.navigator.mediaDevices
    .getUserMedia({ video: true, audio: true })
    .then(localStream => {
        /** @type {HTMLVideoElement} */
        localVideo.srcObject = localStream;
        for (const track of localStream.getTracks()) {
            webrtc.addTrack(track, localStream);
        }
    });

// ADD LISTENERS TO WEBRTC
webrtc.addEventListener("icecandidate", event => {
    if (!event.candidate) {
        return;
    }

    this.sendMessageToSignallingServer({
        channel: "webrtc_ice_candidate",
        candidate: event.candidate,
        otherPerson: otherPerson
    });
});

webrtc.addEventListener("track", event => {
    /** @type {HTMLVideoElement} */
    remoteVideo = document.getElementById("remote-video");
    remoteVideo.srcObject = event.streams[0];
});

/**
 * Sends the message over the socket.
 * @param {WebSocketMessage} message The message to send
 */
function sendMessageToSignallingServer(message) {
    const json = JSON.stringify(message);
    socket.send(json);
}

// ADD LISTERNERS TO WEBSOCKETS
// log in directly after the socket was opened
socket.addEventListener("open", () => {
    console.log("websocket connected");
    this.sendMessageToSignallingServer({
        channel: "login",
        name: this.mydetails.id,
        data: this.mydetails
    });
});

socket.addEventListener("message", event => {
    const message = JSON.parse(event.data.toString());
    this.handleMessage(message);
});

socket.addEventListener("disconnected", event => {
    alert("Disconnected");
});

function showHideUI(element, state) {
    if (element == "ringer") this.ringerui.style.display = state;
}
// updateOnlineUsers(onlineusers, users);
// INIT UI's

this.localusername.innerHTML = this.mydetails.name;

this.rejectcall.addEventListener("click", e => {
    e.preventDefault();
    // REJECT CALL FUNCTION
});

this.acceptcall.addEventListener("click", e => {
    e.preventDefault();
    // ACCEPT CALL FUNCTION
    handleAcceptIncommingCall();
});

showHideUI("ringer", "none");
