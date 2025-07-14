pipeline {
    agent {
        docker {
            image 'docker:latest'
            args '-v /var/run/docker.sock:/var/run/docker.sock'
        }
    }
    environment {
         PATH = "/usr/local/bin:/usr/bin:${PATH}"
         ENVIRONMENT = "PRODUCTION"
    }
    stages {
        stage("Check & Deploy") {
            steps {
                script {
                    def commitMsg = sh(script: "git log -1 --pretty=%B", returnStdout: true).trim()
                    sh "docker-compose -f docker-compose.yml up -d --build"
                }
            }
        }
    }
}
