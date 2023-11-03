pipeline {
    agent any

    stages {
       stage('cloning the repo'){
           steps {
               git branch: 'main', credentialsId: 'git', url: 'https://github.com/saigeeta19/hospital'
             }
           }
    
        stage('Read Password') {
            steps {
                script {
                    // Prompt the user to enter a password
                    def userInput = input(
                        id: 'passwordInput',
                        message: 'Enter the password:',
                        parameters: [
                            string(defaultValue: '', description: 'Password', name: 'PASSWORD')
                        ]
                    )

                    // Retrieve the password entered by the user
                    def password = userInput.PASSWORD

                    // Now you can use the 'password' variable in your script
                    echo "Entered password: ${password}"
                }
            }
        }

        stage('Install PHP Dependencies') {
            steps {
            sh 'sudo apt-get install php'
            }
        }
        stage('Build') {
            steps {
                echo 'hospital'
            }
        }
        stage('Test') {
            steps {
               echo 'hospital'
            }
         }
        stage('Deploy') {
            steps {
               echo 'hospital'
            }
        }
    }
}
    
