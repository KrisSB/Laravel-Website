import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Booklet from './Booklet';


class Deckbuilder extends Component {

    constructor() {
        super();
        this.state = {
            cards: [],
        }
    }

    componentDidMount() {
        /* fetch API in action */
        fetch('/api/deckbuilder')
            .then(response => {
                return response.json();
            })
            .then(cards => {
                console.log(cards);
            });
      }

    render() {
        return (
            <div>
            </div>
        );
    }
}
 
export default Deckbuilder;
 
if (document.getElementById('root')) {
    ReactDOM.render(<Deckbuilder />, document.getElementById('root'));
}