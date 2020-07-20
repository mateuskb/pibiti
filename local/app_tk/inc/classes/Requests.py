#!/var/www/html/pibiti/local/app/env/bin/python3.7

import sys, os
import requests
import base64
import json

BASE_PATH = os.path.abspath(__file__+ '/../../')

sys.path.append(BASE_PATH)

from consts.consts import *

class Requests:


    @staticmethod
    def r_inputs():
        headers= {"User-Agent" : "Mozilla Firefox"}

        url = request_url + '/getInputs'

        try:
            resp = requests.request("GET", url, headers=headers)
            status = resp.status_code
            resp = resp.json()
            if resp['ok']:
                text = resp['data']
            else:
                text = resp['errors']

            text['status'] = status
        except Exception as e:
            text = f'Error: {e}'
        
        return text

    @staticmethod
    def negate(id_input):
        print(f"Negando {id_input}")
        headers= {
            "User-Agent" : "Mozilla Firefox", 
            'Content-Type': 'application/json'
            }
        url = request_url + '/negate'

        try:
            inputs = {"hash": server_hash, "idInput": id_input}
            resp = requests.request("POST", url , headers=headers , data = json.dumps(inputs))
            status = resp.status_code
            resp = resp.json()
            if resp['ok']:
                text = resp['data']
            else:
                text = resp['errors']

            text['status'] = status
        except Exception as e:
            text = f'Error: {e}'
        
        return text