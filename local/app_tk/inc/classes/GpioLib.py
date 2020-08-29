from RPi import GPIO
from inc.consts.consts import *

class Gpiolib:
    """
        Params:
            GPIO => Objeto que controla o gpio do RaspBerry Pi
            pwm => Objeto que controla o pwm do GPIO
        Methods:
            Class => Inicializa o GPIO e configura os outputs
            set_gpio => Altera o valor de um input
            stop => limpa o GPIO
        
        private methods:
            __init_set_up => Configura os outputs
    """
    
    def __init__(self):
        GPIO.setmode(GPIO.BOARD)
        self.__init_set_up()
        self.pwm=False
        
    def __init_set_up(self):
        for i in input_element:
            if i = 'inp_i_fonte':
                self.pwm = GPIO.PWM(input_element[i][2][1], 1000)
                self.pwm.start(12)
            else:
                GPIO.setup(input_element[i][2][1], GPIO.OUT)
        
    def set_gpio(self, pin, value):
        if(pin == input_element['inp_i_fonte'][2][1]):
            try:
                value = int(value)
                value = value / 30 * 100
                if value >= 95:
                    value = 95
                elif value <= 40:
                    value = 40
            except:
                value = 40;
            self.pwm.ChangeDutyCycle(value)
        else :
            if value:
                GPIO.output(pin, GPIO.HIGH)
            else:
                GPIO.output(pin, GPIO.LOW)
    
    def stop(self):        
        if self.pwm:
            pwm.stop()
        GPIO.cleanup()
