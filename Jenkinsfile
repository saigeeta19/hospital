pipeline {
    agent any

    stages {
       stage('cloning the repo'){
           steps {
               git branch: 'main', credentialsId: 'git', url: 'https://github.com/saigeeta19/hospital'
             }
           }
        stage('Build') {
            steps {
               sh 'make' 
                archiveArtifacts artifacts: '**/target/*.jar', fingerprint: true
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
    
