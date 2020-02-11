from RPi import GPIO
from time import sleep

GPIO.setmode(GPIO.BCM)

GPIO.setup(5, GPIO.OUT)

cont = 10

while cont:
    cont -= 1
    GPIO.output(5, GPIO.HIGH)
    sleep(1)
    GPIO.output(5, GPIO.LOW)
    sleep(1)

GPIO.cleanup()
