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
        url = request_url + '/getInputs'

        try:
            resp = requests.request("GET", url)
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
        url = request_url + '/negate'

        try:
            inputs = {"hash": server_hash, "idInput": id_input}
            resp = requests.request("POST", url, data = json.dumps(inputs))
            status = resp.status_code
            resp = resp.json()
            print(resp)
            if resp['ok']:
                text = resp['data']
            else:
                text = resp['errors']

            text['status'] = status
        except Exception as e:
            text = f'Error: {e}'
        
        return text