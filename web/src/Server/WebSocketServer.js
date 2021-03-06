/* (c) Anton Medvedev <anton@elfet.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class WebSocketServer extends AbstractServer {
    constructor(server, port, path) {
        super();
        this.socket = null;
        this.server = server;
        this.port = port;
        this.path = path;
        this.reconnect = null;
    }

    connect() {
        this.socket = new WebSocket('ws://' + this.server + ':' + this.port + this.path);

        this.socket.onopen = () => {
            this.onConnect();
            clearInterval(this.reconnect);
        };

        this.socket.onclose = (event) => {
            if (event.wasClean) {
                this.onDisconnect();
                window.location.reload();
            } else {
                this.onDisconnect();

                clearInterval(this.reconnect);
                this.reconnect = setInterval(() => {
                    this.socket.close();
                    this.connect();
                }, 1000);
            }
        };

        this.socket.onmessage = (receive) => {
            this.onData(JSON.parse(receive.data));
        };

        this.onerror = (error) => {
            this.onError(error.message);
        };
    }

    sendData(data) {
        this.socket.send(data);
    }
}