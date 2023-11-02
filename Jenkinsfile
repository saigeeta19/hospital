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

       
        }
   }
