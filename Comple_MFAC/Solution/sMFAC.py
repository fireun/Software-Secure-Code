
#class function
class AthenticationUser:
    def __init__(self):
        self.users = {
            'Bob' : {'password':'123', 'role':'user'},
            'Ali' : {'password':'pass', 'role':'user'},
            'admin' : {'password': 'admin', 'role':'admin'}
        }

    #compare username and password in above users list
    def verify(self, username, password):

        #found the user in the user list
        if username in self.users and self.users[username]['password'] == password:
            if self.users[username]['role']:
                return self.users[username]['role']
        else:
            return None

class Result:
    def __init__(self):
        self.data = {
            'User_page':'Welcome this is USER  dashboard',
            'Admin_page' : 'Welcome this is ADMIN dasboard',
            'Not_Found' : 'Access Denied: Not Found the username and password'
        }

    #main thing in MFAC tp verify role
    def printResullt(self, user_role):
        if user_role == 'admin':
            return {self.data['Admin_page']}
        elif user_role == 'user':
            return {self.data['User_page']}
        else:
            return {self.data['Not_Found']}

#simulation MFAC function
def main_mfac():
    auth_functuin = AthenticationUser()
    getMessage = Result()

    #as user/admin login
    username = 'Bob'
    password = '123'

    
    check_User = auth_functuin.verify(username, password)
    #print(check_User)
    
    if check_User:
        
        print(f"Usersname: {username}")
        print(f"Password: {password}")

        #check result
        data = getMessage.printResullt(check_User)

        print(f"User Role: {check_User}")
        print(f"Data: {data}")
    else:
        print("Authentication unsuccessful")

#run systemn
main_mfac()



