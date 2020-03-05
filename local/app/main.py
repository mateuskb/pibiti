#!/var/www/html/pibiti/local/app/venv/bin/python3.7
 
import pygame
 

def AAfilledRoundedRect(surface,rect,color,radius=0.4):

    """
    AAfilledRoundedRect(surface,rect,color,radius=0.4)

    surface : destination
    rect    : rectangle
    color   : rgb or rgba
    radius  : 0 <= radius <= 1
    """

    rect         = pygame.Rect(rect)
    color        = pygame.Color(*color)
    alpha        = color.a
    color.a      = 0
    pos          = rect.topleft
    rect.topleft = 0,0
    rectangle    = pygame.Surface(rect.size,pygame.SRCALPHA)

    circle       = pygame.Surface([min(rect.size)*3]*2,pygame.SRCALPHA)
    pygame.draw.ellipse(circle,(0,0,0),circle.get_rect(),0)
    circle       = pygame.transform.smoothscale(circle,[int(min(rect.size)*radius)]*2)

    radius              = rectangle.blit(circle,(0,0))
    radius.bottomright  = rect.bottomright
    rectangle.blit(circle,radius)
    radius.topright     = rect.topright
    rectangle.blit(circle,radius)
    radius.bottomleft   = rect.bottomleft
    rectangle.blit(circle,radius)

    rectangle.fill((0,0,0),rect.inflate(-radius.w,0))
    rectangle.fill((0,0,0),rect.inflate(0,-radius.h))

    rectangle.fill(color,special_flags=pygame.BLEND_RGBA_MAX)
    rectangle.fill((255,255,255,alpha),special_flags=pygame.BLEND_RGBA_MIN)

    return surface.blit(rectangle,pos)


def main():
    # Initialize the game engine
    pygame.init()
    
    # Define some colors
    BLACK = [0, 0, 0]
    WHITE = [255, 255, 255]
    BLUE = [0, 0, 255]
    GREEN = [0, 255, 0]
    RED = [255, 0, 0]
    
    PI = 3.141592653

    running = False
    
    # Loop until the user clicks the close button.
    clock = pygame.time.Clock()
    
    # Set the height and width of the screen
    size = [800, 800] # Screen resolution
    
    screen = pygame.display.set_mode(size)
    
    #button = AAfilledRoundedRect(screen, (275, 250, 250, 150), color=GREEN, radius=0.3)  # creates a rounded rect object
    
    # Clear the screen and set the screen background
    screen.fill(WHITE)

    button = AAfilledRoundedRect(screen, (275, 250, 250, 150), color=GREEN, radius=0.3)  # creates a rounded rect object

    # Select the font to use, size, bold, italics
    font = pygame.font.SysFont('Calibri', 25, True, False)

    # Update display
    pygame.display.update()

    # Loop as long as True
    while True:
        for event in pygame.event.get():  # User did something
            if event.type == pygame.QUIT:  # If user clicked close
                return False
            
            if event.type == pygame.MOUSEBUTTONDOWN:
                mouse_pos = event.pos  # gets mouse position

                # checks if mouse position is over the button

                if button.collidepoint(mouse_pos):
                    # prints current location of mouse
                    print('button was pressed at {0}'.format(mouse_pos))
                    if running:
                        pygame.draw.rect(screen, GREEN, button)
                        running = False
                    else:
                        pygame.draw.rect(screen, RED, button)
                        running = True


        pygame.draw.rect(screen, GREEN, button)

            


        # This limits the while loop to a max of 60 times per second.
        # Leave this out and we will use all CPU we can.
        pygame.display.update()
        clock.tick(60)
    
    # Be IDLE friendly
    pygame.quit()
    sys.exit

if __name__ == "__main__":
    main()
