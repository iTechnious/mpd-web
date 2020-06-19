import os
import json
import time
import requests

import _thread as thread
from mpd import MPDClient
from websocket_server import WebsocketServer

global client
client = MPDClient()
client.timeout = 10
client.idletimeout = None
client.connect("localhost", 6600)

global pic
pic = ""


def gather_data():
    global client

    data = client.currentsong()

    try:
        # title = os.popen("mpc current --format=%title%").readline().replace("\n", "")
        title = data["title"]
    except KeyError:
        title = ""

    try:
        #source = os.popen("mpc current --format=%file%").readline().replace("\n", "")
        source = data["file"]
    except KeyError:
        source = ""

    try:
        #station = os.popen("mpc current --format=%name%").readline().replace("\n", "")
        station = data["name"]
    except KeyError:
        station = ""

    # part = os.popen("mpc volume").readline().replace("\n", "")
    # part = part.split(":")[1]
    # volume = part.replace(" ", "").replace("%", "")
    volume = client.status()["volume"]

    return {
        "song": title,
        "station": station,
        "source": source,
        "volume": volume,
        "time": ""
    }

def initial_send(client, server):
    global pic
    data = gather_data()

    if pic == "":
        if data["source"] != "":
            print("Calling API with: ", data["source"])
            try:
                pic = requests.get("http://de1.api.radio-browser.info/json/stations/byurl", {"url": data["source"]}).json()[0]["favicon"]
            except IndexError:
                pic = ""
    
    data["pic"] = pic

    send = json.dumps(data)

    print("Sending new data: ", send)
    socketserver.send_message_to_all(send)

socketserver = WebsocketServer(8080, host="0.0.0.0")
socketserver.set_fn_new_client(initial_send)
print(">> Socketserver listening (:8080).")

thread.start_new_thread(socketserver.run_forever, ())

os.popen("mpc clear")
os.popen("mpc volume 40")

old_data = {"source": ""}
pic = ""
try:
    while True:
        time.sleep(1)
        data = gather_data()

        if data != old_data:
            if data["source"] != old_data["source"]:
                if data["source"] != "":
                    print("Calling API with: ", data["source"])
                    try:
                        pic = requests.get("http://de1.api.radio-browser.info/json/stations/byurl", {"url": data["source"]}).json()[0]["favicon"]
                    except IndexError:
                        pic = ""
                else:
                    pic = ""

            data["pic"] = pic

            send = json.dumps(data)

            print("Sending new data: ", send)
            socketserver.send_message_to_all(send)
            del data["pic"]

        old_data = data

except KeyboardInterrupt:
    client.close()
    client.disconnect()