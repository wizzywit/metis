import React, { Component } from "react";

class SideUser extends Component {
    render() {
        const { users, parent, role } = this.props;
        return (
            <div className="widget ">
                <h6 className="margin-top-20">
                    {" "}
                    <div className="online-users-tile">
                        <span className="online-dot"></span> Patients Online
                    </div>
                </h6>
                <ul className="widget-tabs shop">
                    {users.length > 0 &&
                        users.map((user, i) => {
                            return (
                                <li key={"ahxbsbshhee_" + i}>
                                    <div className="widget-content">
                                        <div className="widget-thumb">
                                            <a href="#">
                                                <img
                                                    src={
                                                        user.image ||
                                                        require("./Assets/profile.png")
                                                    }
                                                    alt=""
                                                />
                                            </a>
                                        </div>

                                        <div className="widget-text">
                                            <h5>
                                                <a href="#">{user.name}</a>
                                            </h5>
                                            {(role == 1 &&
                                                (user.status == 0 ||
                                                    user.status == 3 ||
                                                    user.status == 4 ||
                                                    user.status == 5) && (
                                                    <a
                                                        href="#"
                                                        className="button margin-top-5 primary"
                                                        onClick={e => {
                                                            e.preventDefault();
                                                            parent.startCall(
                                                                i,
                                                                user
                                                            );
                                                        }}
                                                    >
                                                        <i className="mdi mdi-phone" />{" "}
                                                        {/* {user.status == 0
                                                        ? "Call"
                                                        : "Call again"} */}
                                                        {(user.status == 0 &&
                                                            "Call") ||
                                                            (user.status == 3 &&
                                                                "Call again") ||
                                                            (user.status == 4 &&
                                                                "Rejected! Try again") ||
                                                            (user.status == 5 &&
                                                                "User Busy! Try again")}
                                                    </a>
                                                )) ||
                                                (user.status == 1 && (
                                                    <a
                                                        href="#"
                                                        className="button margin-top-5"
                                                        onClick={e =>
                                                            e.preventDefault()
                                                        }
                                                    >
                                                        Calling...
                                                    </a>
                                                )) ||
                                                (user.status == 2 && (
                                                    <a
                                                        href="#"
                                                        onClick={e => {
                                                            e.preventDefault();
                                                            // parent.endCall(i);
                                                        }}
                                                        className="button margin-top-5"
                                                    >
                                                        <i className="mdi mdi-phone-handup" />{" "}
                                                        Connected
                                                    </a>
                                                ))}
                                        </div>
                                        <div className="clearfix"></div>
                                    </div>
                                </li>
                            );
                        })}
                </ul>
            </div>
        );
    }
}

export default SideUser;
