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
                // You can use Composer to manage PHP dependencies
                sh 'composer install'
            }
        }
        stage('Build') {
            steps {
                index.php
            }
        }
        stage('Test') {
            steps {
               index.php
            }
         }
        stage('Deploy') {
            steps {
               echo 'hospital'
            }
        }
    }
}
    
