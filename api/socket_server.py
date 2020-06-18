import os
import json
import time
import requests

import _thread as thread
from websocket_server import WebsocketServer


def gather_data():
    title = os.popen("mpc current --format=%title%").readline().replace("\n", "")
    
    part = os.popen("mpc volume").readline().replace("\n", "")
    part = part.split(":")[1]
    volume = part.replace(" ", "").replace("%", "")

    source = os.popen("mpc current --format=%file%").readline().replace("\n", "")

    station = os.popen("mpc current --format=%name%").readline().replace("\n", "")

    return {
        "song": title,
        "station": station,
        "source": source,
        "volume": volume,
        "time": ""
    }

def initial_send(client, server):
    data = gather_data()

    print("Calling API with: ", data["source"])
    pic = requests.get("http://de1.api.radio-browser.info/json/stations/byurl", {"url": data["source"]}).json()[0]["favicon"]

    data["pic"] = pic

    send = json.dumps(data)

    print("Sending new data: ", send)
    socketserver.send_message_to_all(send)

socketserver = WebsocketServer(8080, host="0.0.0.0")
socketserver.set_fn_new_client(initial_send)
print(">> Socketserver listening (:8080).")

thread.start_new_thread(socketserver.run_forever, ())

old_data = {"source": ""}
while True:
    time.sleep(1)
    data = gather_data()

    if data != old_data:
        if data["source"] != old_data["source"]:
            print("Calling API with: ", data["source"])
            pic = requests.get("http://de1.api.radio-browser.info/json/stations/byurl", {"url": data["source"]}).json()[0]["favicon"]

        data["pic"] = pic

        send = json.dumps(data)

        print("Sending new data: ", send)
        socketserver.send_message_to_all(send)
        del data["pic"]

    old_data = data
