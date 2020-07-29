import React, { Component } from 'react';
import { BrowserRouter as Router, Switch, Route} from 'react-router-dom';
import VideoCall from './VideoCall';
import ReactDOM from 'react-dom';

class App extends Component {
render() {
      return (
      <Router>
          <div>
            <Switch>
                <Route exact path='/doctor/video/home' render={() => (<VideoCall account_type={1}/>)}/>
                <Route exact path='/patient/video/home' render={() => (<VideoCall account_type={2}/>)}/>
                <Route exact path='/video/call/home' component={VideoCall} />
		     </Switch>
          </div>
        </Router>
      );
    }
  }

  export default App;

if (document.getElementById('conference')) {
    ReactDOM.render(<App />, document.getElementById('conference'));
}
