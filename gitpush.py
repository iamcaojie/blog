import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "添加验证码，重写登录页"')
os.system('git push')
os.system('pause')
