from inc.consts.consts import *

class Modulo:
    """
    Params:
        inputs => Todos os Relés e a voltagem da fonte usados para iniciar o módulo
        __run => Decide se o módulo deverá ou não ser inicializado
        running => Indica se o módulo está rodando ou não
    
    Methods:
        start => Inicializa o módulo
        update_inputs => Altera o valor dos inputs
        stop => desliga o módulo
    
    private methods:
        verify_inputs => Verifica se os inputs causaram algum dano ao módulo
    """
    def __init__(self, inputs=default_inputs, run=True):
        #self.__inputs = inputs
        self.__run = run
        self.running = False

        if self.__run:
            self.start(inputs)
    
    def start(self, inputs=default_inputs):
        self.running = True
        return True

    def update_inputs(self, inputs):
        if self.running:
            if self.__verify_inputs(inputs):
                return True
            else:
                return False
        else: 
            return False

    def stop(self):
        self.running = False
        return True

    def __verify_inputs(self, inputs):
        if inputs['inp_b_rele1'] == '1':
            return False
        return True
