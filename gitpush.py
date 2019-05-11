import os

address = os.path.abspath(os.path.dirname(__file__))
print(address)
os.system('git add .')
os.system('git commit -m "修复邮箱验证码验证错误的bug"')
os.system('git push')
os.system('pause')
