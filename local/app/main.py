#!/var/www/html/pibiti/local/app/venv/bin/python3.7

import pygame, math, sys, os
from time import sleep
from itertools import chain

pygame.init()

#Variables
darkYellow = 204,204,0
grey = 102, 102, 102
light_grey = 243, 243, 243
ccc = 204,204,204
black = 0, 0, 0
white = 255, 255, 255
red = 255,0,0
usual_red = 203,30,53
marroon = 120, 0, 0
green = 0,255,0
light_green = 35,168,78
blue = 0,0,255
darkBlue = 0,0,128

resolution = 800, 800
my_font = pygame.font.SysFont("Times New Roman", 30)
my_font2 = pygame.font.SysFont("Times New Roman", 15)
my_font3 = pygame.font.SysFont("Times New Roman", 60)

start_x = 275
start_y = 200
rectWidth = 250
rectHeight = 80

log_pos = [60, 410]


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
    window.fill(ccc)

    if running:
        button = pygame.draw.rect(window, (usual_red), (start_x, start_y, rectWidth, rectHeight), 0)
        log = pygame.draw.rect(window, (light_grey), (50, 400, 700, 350), 0)
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
    text = 'Running'

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
    
    lines = lines[-10: -1]
    lines = wrap_multi_line(lines, my_font2, 390)
    
    labels = []
    for line in lines[-11: -1]:
        l = my_font2.render(line, 2, grey)
        labels.append(l)

    for line in range(len(labels)):
        window.blit(labels[line],(log_pos[0],log_pos[1]+(line*15)+(15*line)))

    #print(help(labels[0]))



if __name__ == "__main__":
    main()