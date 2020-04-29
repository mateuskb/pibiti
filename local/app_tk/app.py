#!/var/www/html/pibiti/local/app_tk/env/bin/python3.6

import tkinter as tk
import tkinter.font as tkFont
from PIL import ImageTk,Image
import ast


from inc.consts.consts import *
from inc.classes.Requests import Requests
from inc.classes.Modulo import Modulo


def main():
    class GUI:
        def __init__(self, master):
            
            # var
            self.modulo = None
            self.last_line = ''
            self.inputs = {}

            # basic information
            self.master = master
            self.master.title("Controle do módulo")
            self.master.minsize(resolution[0], resolution[1])
            self.master.maxsize(resolution[0], resolution[1])

            # fonts 
            h1 = tkFont.Font(family="Times New Roman", size=38)
            text1 = tkFont.Font(family="Times New Roman", size=18)

            # images
            self.module_image = ImageTk.PhotoImage(file = image_url)

            # elements
            self.title = tk.Label(self.master, text="Controle do módulo!", font=h1, fg='grey20', pady=15)

            self.main_button = tk.Button(self.master, text="Iniciar", bg='green', fg='white', command=self.run, height=3, width=20, font=text1)

            self.canvas = tk.Canvas(width = 700, height = 500)

            self.build()

        def build(self):
            # pack everything and show in the screen
            self.title.pack(pady=30)
            self.main_button.pack(pady=20)
            self.canvas.pack(pady=0)
            self.modulo = Modulo(run=False)
            


        def run(self):
            # run code
            if not self.modulo.running:
                # start running
                self.modulo.start()

                def read_inputs():
                    # read inputs
                    if self.modulo.running:
                        
                        resp = Requests.r_inputs()
                        #print(resp)
                        if resp:
                            text = str(resp)
                        else:
                            text = 'Erro na conexão com o servidor'

                        if not text == self.last_line:
                            try:
                                self.inputs = ast.literal_eval(text)
                                self.last_line = text
                                self.update_image()
                            except:
                                pass


                        self.master.after(100, read_inputs)

                read_inputs()
            else:
                # stop running
                self.modulo.stop()

            self.change_main_button_run()
        
        def change_main_button_run(self):
            if self.main_button['bg'] == 'green':
                self.main_button['bg'] = 'red'
                self.main_button['text'] = 'Desligar'
            else:
                self.main_button['bg'] = 'green'
                self.main_button['text'] = 'Iniciar'
        
        def update_image(self):
            # delete everything in canvas
            self.canvas.delete('all')
            # recreate image
            self.canvas.create_image(0, 0, image = self.module_image, anchor='nw')

            # light on values == '1'
            for key, value in self.inputs.items():
                if key in input_element.keys():
                    if value == '1':
                        self.canvas.create_rectangle(input_element[key][0], input_element[key][1], input_element[key][0]+size_x, input_element[key][1]+size_y, fill='yellow')


    root = tk.Tk()
    my_gui = GUI(root)
    root.mainloop()

if __name__ == "__main__":
    main()