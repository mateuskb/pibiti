#!/var/www/html/pibiti/local/app/venv/bin/python3.7

# Resolution
resolution = 720, 720

# Input positions
size_x = 20
size_y = 20
elements = ('inp_i_fonte', "inp_b_rele1", "inp_b_rele2", "inp_b_rele3", "inp_b_rele4", "inp_b_rele5", "inp_b_rele6", "inp_b_rele7", "inp_b_rele8", "inp_b_rele9", "inp_b_rele10", "inp_b_rele11", "inp_b_rele12", "inp_b_rele13")
input_element = {
    # fonte
    "inp_i_fonte" : [['Fonte :', [55,50]], [100, 50], ['VCC', 10]],
    # reles
    "inp_b_rele1" : [['Relé 1 : ', [200, 250]], [250, 240], ['R1A', 8]],
    "inp_b_rele2" : [['Relé 2 : ',[200, 350]], [250, 340], ['R2A', 3]],
    "inp_b_rele3" : [['Relé 3 : ',[200, 450]], [250, 440], ['R3A', 5]],
    "inp_b_rele4" : [['Relé 4 : ',[350, 250]], [400, 240], ['R1B', 7]],
    "inp_b_rele5" : [['Relé 5 : ', [350, 350]], [400, 340], ['R2B', 29]],
    "inp_b_rele6" : [['Relé 6 : ', [350, 450]], [400, 440], ['R3B', 31]],
    "inp_b_rele7" : [['Relé 7 : ', [500, 250]], [550, 240], ['R1C', 26]],
    "inp_b_rele8" : [['Relé 8 : ', [500, 350]], [550, 340], ['R2C', 24]],
    "inp_b_rele9" : [['Relé 9 : ', [500, 450]], [550, 440], ['R3C', 21]],
    "inp_b_rele10" : [['Relé 10 : ', [200, 150]], [250, 140], ['R0A', 19]],
    "inp_b_rele11" : [['Relé 11 : ', [350, 150]], [400, 140], ['R0B', 23]],
    "inp_b_rele12" : [['Relé 12 : ', [500, 150]], [550, 140], ['R0C', 32]],
    "inp_b_rele13" : [['Relé 13 : ', [50, 250]], [100, 240], ['R0', 33]],
}

# urls
request_url_local = 'http://localhost/pibiti/web/back/public'
request_url = 'http://api.appfeliz.com.br/pibiti/public'
#image_url = '/home/pi/Documents/programming/pibiti/local/app_tk/inc/images/modulo.png'

default_inputs = {} # TO DO

server_hash = '$2y$12$YUehdI4CZ9wh4B8za.Tz5e6j0Zk.OJLmOl.EtzCiQpxA4zsHfA.cK' # Usado para cancelar inputs caso não forem permitidos