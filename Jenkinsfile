pipeline {
    agent any

    stages {
       stage('cloning the repo'){
           steps {
               git branch: 'main', credentialsId: 'git', url: 'https://github.com/saigeeta19/hospital'
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
    
