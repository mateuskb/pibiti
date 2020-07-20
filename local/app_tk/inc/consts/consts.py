#!/var/www/html/pibiti/local/app/venv/bin/python3.7

# Resolution
resolution = 800, 800

# Input positions
size_x = 11
size_y = 60
input_element = {
    # fonte
    "inp_i_fonte" : [114, 265],
    # outros
    "inp_b_rele1" : [134, 135],
    "inp_b_rele2" : [274, 50],
    "inp_b_rele3" : [414, 50],
    "inp_b_rele4" : [554, 50],
    # first line
    "inp_b_rele5" : [274, 135],
    "inp_b_rele6" : [274, 235],
    "inp_b_rele7" : [274, 339],
    # second line
    "inp_b_rele8" : [414, 135],
    "inp_b_rele9" : [417, 235],
    "inp_b_rele10" : [420, 339],
    # third line
    "inp_b_rele11" : [554, 135],
    "inp_b_rele12" : [558, 235],
    "inp_b_rele13" : [562, 339],
}

# urls
request_url_local = 'http://localhost/pibiti/web/back/public'
request_url = 'http://api.appfeliz.com.br/pibiti/public'
image_url = './inc/images/modulo.png'

default_inputs = {} # TO DO

server_hash = '$2y$12$YUehdI4CZ9wh4B8za.Tz5e6j0Zk.OJLmOl.EtzCiQpxA4zsHfA.cK' # Usado para cancelar inputs caso não forem permitidos