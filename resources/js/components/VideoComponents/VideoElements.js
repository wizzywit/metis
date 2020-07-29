import React, { Component } from "react";

export class OffVideo extends Component {
    render() {
        const { pause, muted } = this.props;
        if (pause || muted)
            return (
                <div className={`off-video ${muted && !pause && "mute-video"}`}>
                    <div className="off-video-inner">
                        <i
                            className={`mdi mdi-${
                                pause ? "camera" : "microphone"
                            }-off`}
                        ></i>
                    </div>
                </div>
            );
        else return <div></div>;
    }
}

export class EndCall extends Component {
    render() {
        const { ended, type, text, role } = this.props;
        if (ended)
            return (
                <div
                    className={`off-video ${
                        type == 1 ? "call-ended" : "call-ended-2"
                    }`}
                >
                    <div className="off-video-inner">
                        <i className={`mdi mdi-phone-hangup`}></i>
                        {type == 1 && (
                            <p>
                                {text ||
                                    `${
                                        role == 1
                                            ? "Call ended, call a patient from the side panel!"
                                            : "Call ended, doctor will call soon!"
                                    }`}
                            </p>
                        )}
                    </div>
                </div>
            );
        else return <div></div>;
    }
}

export class ReceiveCall extends Component {
    render() {
        const { isRinging, caller, parent } = this.props;
        if (isRinging)
            return (
                <div
                    className={`off-video call-ended`}
                    style={{ background: "#eeeeef" }}
                >
                    <div className="off-video-inner" style={{ marginTop: 0 }}>
                        <div className="telephone">
                            <img
                                src={require("./Assets/telephone-service.gif")}
                            />
                        </div>

                        <p className="margin-top-15 margin-bottom-15">
                            <span style={{ fontWeight: 100 }}>
                                You have an incoming call from
                            </span>{" "}
                            {parent.getUserWithID(caller).name +
                                " (" +
                                caller +
                                ")"}
                            .
                        </p>
                        <div
                            className="controls"
                            style={{ bottom: "auto", width: 150 }}
                        >
                            <a
                                href="#"
                                className={`button danger`}
                                onClick={e => {
                                    e.preventDefault();
                                    parent.handleRejectCall();
                                }}
                            >
                                <i className="mdi mdi-phone-hangup"></i>
                            </a>
                            <a
                                href="#"
                                className={`button success`}
                                onClick={e => {
                                    e.preventDefault();
                                    parent.handleAcceptIncommingCall();
                                }}
                            >
                                <i className="mdi mdi-phone"></i>
                            </a>
                        </div>
                    </div>
                </div>
            );
        else return <div></div>;
    }
}
