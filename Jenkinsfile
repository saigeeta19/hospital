pipeline {
    agent any

    stages {
       stage('cloning the repo'){
           git branch: 'main', credentialsId: 'reigatehospice', url: 'https://github.com/saigeeta19/hospital.git'
       }
        stage('Build') {
            steps {
               echo 'Building the App'
            }
        }

        stage('Test') {
            steps {
                echo 'Testing the App'
            }
        }

        stage('Deploy') {
            steps {
               echo 'Deploying the App'
            }
        }
    }

  
}
