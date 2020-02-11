
from RPi import GPIO
from time import sleep

GPIO.setmode(GPIO.BCM)

GPIO.setup(5, GPIO.OUT)

pwm = GPIO.PWM(5, 100)
pwm.start(0)

dc = 0
flag = True

'''while True:
    pwm.ChangeDutyCycle(dc)
    sleep(0.1)
    
    if flag:
        dc += 1
        if dc == 100:
            flag = False
    else:
        dc -= 1
        if dc == 0:
            flag = True
'''

pwm.ChangeDutyCycle(90)
sleep(10)

GPIO.cleanup()

