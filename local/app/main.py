#!/var/www/html/pibiti/local/app/venv/bin/python3.7

import pygame, math, sys, os
from time import sleep

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

    cur_path = os.path.dirname(__file__)
    log_file = open(cur_path+ "/log/log.txt", 'w')
    logs_file = open(cur_path+ "/log/logs.txt", 'a')

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
            text = game()
            sleep(0.1)
            log_file.write(text + '\n')
            logs_file.write(text + '\n')
            write_log()
            
        clock.tick(60)
        
    log_file.close()
    logs_file.close()

def game(): 
    sleep(1)
    return 'Running'
    
def write_log():
    print("------------------------")
    text = ''
    cur_path = os.path.dirname(__file__)
    with open(cur_path+ "/log/logs.txt", 'r') as log:
        lines = log.read().splitlines()
        for line in lines[-50: -1]:
            text += line + '\n'
    
    print(text)



if __name__ == "__main__":
    main()