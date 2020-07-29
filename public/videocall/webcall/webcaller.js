function onlineUser(user, index) {
    var tmpDiv = document.createElement("div");
    tmpDiv.innerHTML = `
                <div class="widget-content">
                <div class="widget-thumb">
                <a href="#"><img src="${user.image ||
                    "../videocall/Assets/images/profile.png"}" alt="">
                </a>
                </div><div class="widget-text">
                <h5><a href="#">${user.name}</a>
                </h5><a href="#" onClick="startCall(${index},${user.id}, ${
        user.status
    })" class="button margin-top-5 primary">
                <i class="mdi mdi-phone"></i> ${(user.status == 0 && "Call") ||
                    (user.status == 1 && "Calling...") ||
                    (user.status == 2 && "Connected") ||
                    (user.status == 5 && "Busy, try again.")}</a>
                </div><div class="clearfix">

                </div>
                </div>

        `;
    return tmpDiv;
}

function updateOnlineUsersUI(sidepanel, users) {
    sidepanel.innerHTML = "";
    users.forEach((user, i) => {
        sidepanel.appendChild(this.onlineUser(user, i));
    });
}

function callSomeone(userid) {
    alert(userid);
}

/**
 * Processes the incoming message.
 * @param {WebSocketMessage} message The incoming message
 */
async function handleMessage(message) {
    let otherPerson = message.otherPerson;
    let members = [];
    if (otherPerson == null) {
        otherPerson = this.otherPerson;
    } else {
        this.otherPerson = message.otherPerson;
    }

    switch (message.channel) {
        case "start_call":
            console.log(`receiving call from ${message}`);
            const offer = await webrtc.createOffer();
            await webrtc.setLocalDescription(offer);
            sendMessageToSignallingServer({
                channel: "webrtc_offer",
                offer,
                otherPerson
            });
            break;

        case "webrtc_ice_candidate":
            console.log("received ice candidate");
            console.log(message);
            await webrtc.addIceCandidate(message.candidate);
            break;

        case "call_accepted":
            console.log("Call accepted");
            console.log(message);
            updateUserAccepted(message);
            break;

        case "webrtc_offer":
            console.log("received webrtc offer");
            await webrtc.setRemoteDescription(message.offer);
            const answer = await webrtc.createAnswer();
            await webrtc.setLocalDescription(answer);

            sendMessageToSignallingServer({
                channel: "webrtc_answer",
                answer,
                otherPerson
            });

            break;

        case "webrtc_answer":
            console.log("received webrtc answer: -- " + message.otherPerson);
            this.call = {
                isRinging: true,
                caller: message.otherPerson,
                message
            };

            this.ringer.play();
            // START RINGER UI
            showHideUI("ringer", "");
            // END RINGER UI

            let timer = 0;
            this.interval = setInterval(() => {
                if (timer >= 30) {
                    this.ringer.pause();
                    this.call = {
                        isRinging: false,
                        caller: null,
                        message: {}
                    };
                    showHideUI("ringer", "none");
                    sendMessageToSignallingServer({
                        channel: "noanswer",
                        otherPerson: this.otherPerson
                    });

                    clearInterval(this.interval);
                }
                timer++;
            }, 1000);

            break;
        case "noanswer":
            this.users.forEach(user => {
                if (user.id == otherPerson) {
                    user.status = 5;
                }
                members.push(user);
            });
            this.users = members;
            updateOnlineUsersUI(this.onlineusers, this.users);

        default:
            processCustomSocket(message);
            break;
    }
}

// UPDATE ONLINE USERS

function updateUserAccepted(member) {
    const users = this.users;
    let localvideo = this.localvideo;
    let members = [];
    users.forEach(user => {
        if (user.id == member.otherPerson) {
            user.status = 2;
            // localvideo.endcall = false;
        }
        members.push(user);
    });
    this.users = members;
    // this.setState({ users: members, localvideo });
    updateOnlineUsersUI(this.onlineusers, this.users);
}

function processCustomSocket(message) {
    switch (message.action) {
        case "joined":
            updateActiveUsers(message.users, message.memberdata);
            break;
        case "left":
            updateActiveUsers(
                removeUserIfNotRemoved(message.users, message.memberdata),
                message.memberdata
            );
            break;
        case "endcall":
            updateEndCall(
                removeUserIfNotRemoved(message.users, message.memberdata),
                message.memberdata
            );
            break;
        default:
            break;
    }
}

function endcall(index) {
    this.users[index].status = 0;
    updateOnlineUsersUI(this.onlineusers, this.users);
}

function updateActiveUsers(users, member) {
    let members = [];
    users.forEach(user => {
        if (user.data.id !== this.mydetails.id) members.push(user.data);

        if (user.data.id == member.id) {
            user.data.status = 3;
        }
    });
    this.users = members;
    updateOnlineUsersUI(this.onlineusers, this.users);
}

function removeUserIfNotRemoved(users, memberdata) {
    let data = [];
    users.forEach(user => {
        if (!user.data.id == memberdata.id) {
            data.push(user.data);
        }
    });
    return data;
}

function startCall(index, user, status) {
    this.users[index].status = 1;
    this.otherPerson = user;
    sendMessageToSignallingServer({
        channel: "start_call",
        otherPerson: user
    });
    updateOnlineUsersUI(this.onlineusers, this.users);
}

// ACCEPT INCOMING CALL
async function handleAcceptIncommingCall() {
    this.call.isRinging = false;
    this.ringer.pause();
    clearInterval(this.interval);
    showHideUI("ringer", "none");
    webrtc.setRemoteDescription(this.call.message.answer);
    sendMessageToSignallingServer({
        channel: "call_accepted",
        otherPerson: this.otherPerson
    });
    this.updateUserAccepted(this.call.message);
}
