import React, { Component } from 'react';
import { BrowserRouter as Router, Switch, Route} from 'react-router-dom';
import Doctor from './Doctor';
import Patient from './Patient';
import ReactDOM from 'react-dom';

class App extends Component {
    render() {
      return (
      <Router>
          <div>
            <Switch>
                <Route exact path='/doctor/video/home' component={Doctor} />
                <Route exact path='/patient/video/home' component={Patient} />
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
