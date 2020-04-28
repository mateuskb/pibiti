#!/var/www/html/pibiti/local/app_tk/env/bin/python3.6

import tkinter as tk
import tkinter.font as tkFont
from PIL import ImageTk,Image
import ast


from inc.consts.consts import *
from inc.classes.Requests import Requests


def main():
    class GUI:
        def __init__(self, master):
            
            # var
            self.running = 0
            self.last_line = ''

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
            self.canvas.create_image(0, 0, image = self.module_image, anchor='nw')


        def run(self):
            # run code
            if not self.running:
                # start running
                self.running = 1

                def read_inputs():
                    # read inputs
                    if self.running:
                        
                        resp = Requests.r_inputs()
                        #print(resp)
                        if resp:
                            text = str(resp)
                        else:
                            text = 'Erro na conexão com o servidor'

                        if not text == self.last_line:
                            self.last_line = text
                            self.update_image()
                            print(self.last_line)


                        self.master.after(100, read_inputs)
                read_inputs()
            else:
                # stop running
                self.running = 0

            self.change_main_button_run()
        
        def change_main_button_run(self):
            if self.main_button['bg'] == 'green':
                self.main_button['bg'] = 'red'
                self.main_button['text'] = 'Desligar'
            else:
                self.main_button['bg'] = 'green'
                self.main_button['text'] = 'Iniciar'
        
        def update_image(self):
            boxes = {}
            for key, value in ast.literal_eval(self.last_line).items():
                if key in input_element.keys():
                    if value == '1':
                        boxes[key] = self.canvas.create_rectangle(input_element[key][0], input_element[key][1], input_element[key][0]+size_x, input_element[key][1]+size_y, fill='yellow')
                    else:
                        try:
                            self.canvas.delete(boxes[key])
                        except Exception as e:
                            print(e)
            print(boxes)


    root = tk.Tk()
    my_gui = GUI(root)
    root.mainloop()

if __name__ == "__main__":
    main()