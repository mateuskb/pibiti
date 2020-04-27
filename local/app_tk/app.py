#!/var/www/html/pibiti/local/app_tk/env/bin/python3.6

import tkinter as tk
import tkinter.font as tkFont

from inc.consts.consts import *
from inc.classes.Requests import Requests


def main():
    class GUI:
        def __init__(self, master):
            
            # var
            self.running = 0

            # basic information
            self.master = master
            self.master.title("Controle do módulo")
            self.master.minsize(resolution[0], resolution[1])
            self.master.maxsize(resolution[0], resolution[1])

            # fonts 
            h1 = tkFont.Font(family="Times New Roman", size=38)
            text1 = tkFont.Font(family="Times New Roman", size=18)


            # elements
            self.title = tk.Label(self.master, text="Controle do módulo!", font=h1, fg='grey20', pady=15)

            self.main_button = tk.Button(self.master, text="Iniciar", bg='green', fg='white', command=self.run, height=3, width=20, font=text1)

            self.build()

        def build(self):
            # pack everything and show in the screen
            self.title.pack(pady=30)
            self.main_button.pack(pady=50)

        def run(self):
            if not self.running:
                self.running = 1
                print("Greetings!")
            else:
                self.running = 0

            self.change_main_button_run()
        
        def change_main_button_run(self):
            if self.main_button['bg'] == 'green':
                self.main_button['bg'] = 'red'
                self.main_button['text'] = 'Desligar'
            else:
                self.main_button['bg'] = 'green'
                self.main_button['text'] = 'Iniciar'

    root = tk.Tk()
    my_gui = GUI(root)
    root.mainloop()

if __name__ == "__main__":
    main()