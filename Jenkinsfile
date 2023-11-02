pipeline {
    agent any

    stages {
       stage('cloning the repo'){
           steps {
               git branch: 'main', credentialsId: 'reigatehospice', url: 'https://github.com/saigeeta19/hospital.git'
             }
           }
        stage('Build') {
            steps {
               build 'hospital'
            }
        }

        stage('Test') {
            steps {
                test 'hospital'
            }
        }

        stage('Deploy') {
            steps {
               echo 'Deploying the App'
            }
        }
    }

  
}
