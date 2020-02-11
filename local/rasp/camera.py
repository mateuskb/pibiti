import picamera     
import curses
import os

def main(win):
    with picamera.PiCamera() as camera:
        camera.start_preview()
        win.nodelay(True)
        while 1:          
            try:                 
               key = win.getkey()
               if key == 'q':
                   camera.stop_preview()
            except Exception as e: 
               pass         

curses.wrapper(main)

