import Reveal from "stimulus-reveal-controller";

export default class extends Reveal {
    connect() {
        super.connect();
        console.log('hohoas')
    }
}