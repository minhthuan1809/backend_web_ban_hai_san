pipeline {
    agent any
    environment {
         PATH = "/usr/local/bin:/usr/bin:${PATH}"
    }
    stages {
        stage("Check & Deploy") {
            steps {
                script {
                    def commitMsg = sh(script: "git log -1 --pretty=%B", returnStdout: true).trim()
                    try {
                        sh "sudo docker-compose -f docker-compose.yml up -d --build"
                        sh """
                            curl -s -X POST "https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage" \
                            -d "chat_id=${CHAT_ID}" \
                            -d "text=[${env.ENVIRONMENT}] ${env.JOB_NAME} – Build SUCCESS!"
                        """
                    } catch (Exception e) {
                        sh """
                            curl -s -X POST "https://api.telegram.org/bot${TELEGRAM_BOT_TOKEN}/sendMessage" \
                            -d "chat_id=${CHAT_ID}" \
                            -d "text=[${env.ENVIRONMENT}] ${env.JOB_NAME} – Build FAILED!"
                        """
                        throw e
                    }
                }
            }
        }
    }
}
