#!/var/www/html/pibiti/local/app/env/bin/python3.7

import pygame, math, sys, os
from time import sleep
from itertools import chain
import datetime
from inc.consts.consts import *
from inc.classes.Requests import Requests

pygame.init()

#Variables
my_font = pygame.font.SysFont("Times New Roman", 30)
my_font2 = pygame.font.SysFont("Times New Roman", 15)
my_font3 = pygame.font.SysFont("Times New Roman", 60)


def truncline(text, font, maxwidth):
        real=len(text)       
        stext=text           
        l=font.size(text)[0]
        cut=0
        a=0                  
        done=1
        old = None
        while l > maxwidth:
            a=a+1
            n=text.rsplit(None, a)[0]
            if stext == n:
                cut += 1
                stext= n[:-cut]
            else:
                stext = n
            l=font.size(stext)[0]
            real=len(stext)               
            done=0                        
        return real, done, stext       


def wrapline(text, font, maxwidth): 
    done=0                      
    wrapped=[]                  
                            
    while not done:             
        nl, done, stext=truncline(text, font, maxwidth) 
        wrapped.append(stext.strip())                  
        text=text[nl:]                                 
    return wrapped
        
def wrap_multi_line(text, font, maxwidth):
    """ returns text taking new lines into account.
    """
    lines = chain(*(wrapline(line, font, maxwidth) for line in text))
    return list(lines)


def clock_page():
    #window.fill(ccc)

    if running:
        button = pygame.draw.rect(window, (usual_red), (start_x, start_y, rectWidth, rectHeight), 0)
        #log = pygame.draw.rect(window, (light_grey), (50, 400, 700, 350), 0)
    else:
        button = pygame.draw.rect(window, (light_green), (start_x, start_y, rectWidth, rectHeight), 0)

        
    for element in elements:
        
        if element[0] == 'end' and not running:            
            pass
        elif element[0] == 'start' and running:  
            pass
        else:
            window.blit(element[1], element[2]) 
            


    pygame.display.update()
    
def main():
    global window, clock
    clock = pygame.time.Clock()
    window = pygame.display.set_mode(resolution)
    window.fill(ccc)
    pygame.display.set_caption('Módulo control')
    main_menu()


def main_menu():
    global elements, running

    # Local variables
    running = False

    # Draw buttons
    button = pygame.draw.rect(window, (light_green), (start_x, start_y, rectWidth, rectHeight), 0)
    start_button = my_font3.render("Iniciar", 2, ccc)
    end_button = my_font3.render("Desligar", 2, ccc)

    # Draw title
    title = my_font3.render("Controle do módulo", 2, grey)

    
    # Insert into the window
    elements = [
        ['titulo', title, (170, 70)],
        ['start', start_button, (start_x + 48, start_y + 6)],
        ['end', end_button, (start_x + 28, start_y + 6)]
    ]

    while True:
        for event in pygame.event.get():
            
            if event.type == pygame.QUIT:
                return False

            elif event.type == pygame.MOUSEBUTTONDOWN:
                if event.button == 1:
                    if button.collidepoint(event.pos):
                        if running:
                            running = False
                        else:
                            running = True
        
        clock_page()

        if running:
            game()
            
        clock.tick(60)
        
def game(): 
    resp = Requests.r_inputs()
    if resp:
        text = str(resp)
    else:
        text = 'Erro na conexão com o servidor'
    print(text)
    #text = 'Running ' + datetime.date.today().strftime("%Y-%m-%d_%H:%M:%S")

    cur_path = os.path.dirname(__file__)

    with open(cur_path+ "/log/logs.txt", 'a') as logs_file:
        logs_file.write(text + '\n')

    read_log()
    sleep(0.1)
    
def read_log():
    print("------------------------")
    text = ''
    cur_path = os.path.dirname(__file__)
    with open(cur_path+ "/log/logs.txt", 'r') as log:
        lines = log.read().splitlines()
    
    lines = lines[-13: -1]
    lines = wrap_multi_line(lines, my_font2, 390)
    lines = lines[-13: -1]
    labels = []
    for line in lines:
        l = my_font2.render(line, 2, black)
        labels.append(l)
        print(line)

    pygame.draw.rect(window, (light_grey), (50, 400, 700, 350), 0)
    for line in range(len(labels)):
        window.blit(labels[line],(log_pos[0],log_pos[1]+(line*15)+(15*line)))



if __name__ == "__main__":
    main()