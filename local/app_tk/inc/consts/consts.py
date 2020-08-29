#!/var/www/html/pibiti/local/app/venv/bin/python3.7

# Resolution
resolution = 800, 800

# Input positions
size_x = 20
size_y = 20
input_element = {
    # fonte
    "inp_i_fonte" : [['Fonte :', [55,50]], [100, 50], ['VCC', 10]],
    # outros
    "inp_b_rele1" : [['Relé 1 : ', [50, 250]], [100, 240], ['R0', 8]],
    # first line
    "inp_b_rele2" : [['Relé 2 : ',[200, 150]], [250, 140], ['R0A', 3]],
    "inp_b_rele3" : [['Relé 3 : ',[200, 250]], [250, 240], ['R1A', 5]],
    "inp_b_rele4" : [['Relé 4 : ',[200, 350]], [250, 340], ['R2A', 7]],
    "inp_b_rele5" : [['Relé 5 : ', [200, 450]], [250, 440], ['R3A', 29]],
    # second line
    "inp_b_rele6" : [['Relé 6 : ', [350, 150]], [400, 140], ['R0B', 31]],
    "inp_b_rele7" : [['Relé 7 : ', [350, 250]], [400, 240], ['R1B', 26]],
    "inp_b_rele8" : [['Relé 8 : ', [350, 350]], [400, 340], ['R2B', 24]],
    "inp_b_rele9" : [['Relé 9 : ', [350, 450]], [400, 440], ['R3B', 21]],
    # third line
    "inp_b_rele10" : [['Relé 10 : ', [500, 150]], [550, 140], ['R0C', 19]],
    "inp_b_rele11" : [['Relé 11 : ', [500, 250]], [550, 240], ['R1C', 23]],
    "inp_b_rele12" : [['Relé 12 : ', [500, 350]], [550, 340], ['R2C', 32]],
    "inp_b_rele13" : [['Relé 13 : ', [500, 450]], [550, 440], ['R3C', 33]],
}

# urls
request_url_local = 'http://localhost/pibiti/web/back/public'
request_url = 'http://api.appfeliz.com.br/pibiti/public'
#image_url = '/home/pi/Documents/programming/pibiti/local/app_tk/inc/images/modulo.png'

default_inputs = {} # TO DO

server_hash = '$2y$12$YUehdI4CZ9wh4B8za.Tz5e6j0Zk.OJLmOl.EtzCiQpxA4zsHfA.cK' # Usado para cancelar inputs caso não forem permitidos