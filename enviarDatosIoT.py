"""Codigo recuperado de: https://help.ubidots.com/en/articles/569964-simulate-data-in-ubidots-using-python"""
import time
import requests
import math
import random

TOKEN = "BBFF-ExujAR4QuVSmaewBimHlPAmL6n5TuK"  # Put your TOKEN here
DEVICE_LABEL = "Demo"  # Put your device label here 
VARIABLE_LABEL_1 = "Nivel Tanque"  # Put your first variable label here
VARIABLE_LABEL_2 = "Nivel Turbidez"  # Put your second variable label here
VARIABLE_LABEL_3 = "Coagulante"  # Put your second variable label here
VARIABLE_LABEL_4 = "Floculante"  # Put your second variable label here
VARIABLE_LABEL_5 = "Cloro"  # Put your second variable label here

def build_payload(variable_1, variable_2, variable_3,variable_4,variable_5,
                 nivelTanque,nivelTurbidez,coagulante,floculante,cloro):
    payload = {variable_1: nivelTanque,
               variable_2: nivelTurbidez,
               variable_3: coagulante,
               variable_4: floculante,
               variable_5: cloro}

    return payload


def post_request(payload):
    # Creates the headers for the HTTP requests
    url = "http://industrial.api.ubidots.com"
    url = "{}/api/v1.6/devices/{}".format(url, DEVICE_LABEL)
    headers = {"X-Auth-Token": TOKEN, "Content-Type": "application/json"}

    # Makes the HTTP requests
    status = 400
    attempts = 0
    while status >= 400 and attempts <= 5:
        req = requests.post(url=url, headers=headers, json=payload)
        status = req.status_code
        attempts += 1
        time.sleep(1)

    # Processes results
    print(req.status_code, req.json())
    if status >= 400:
        print("[ERROR] Could not send data after 5 attempts, please check \
            your token credentials and internet connection")
        return False

    print("[INFO] request made properly, your device is updated")
    return True


def enviarDatos(nivelTanque,nivelTurbidez,coagulante,floculante,cloro):
    payload = build_payload(VARIABLE_LABEL_1, VARIABLE_LABEL_2, VARIABLE_LABEL_3, VARIABLE_LABEL_4,VARIABLE_LABEL_5,
                            nivelTanque,nivelTurbidez,coagulante,floculante,cloro)

    print("[INFO] Attemping to send data")
    post_request(payload)
    print("[INFO] finished")

