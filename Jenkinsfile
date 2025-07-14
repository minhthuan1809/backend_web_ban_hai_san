pipeline {
    agent any
    environment {
         PATH = "/usr/local/bin:/usr/bin:${PATH}"
         ENVIRONMENT = "PRODUCTION"
    }
    stages {
        stage("Check & Deploy") {
            steps {
                script {
                    def commitMsg = sh(script: "git log -1 --pretty=%B", returnStdout: true).trim()
                    
                    // Thay thế docker-compose bằng các lệnh Docker riêng lẻ
                    // Giả định container tên là 'web_ban_hai_san'
                    sh """
                        if docker ps -a | grep -q web_ban_hai_san; then
                            docker stop web_ban_hai_san
                            docker rm web_ban_hai_san
                        fi
                        docker build -t web_ban_hai_san:latest .
                        docker run -d --name web_ban_hai_san -p 9999:9999 web_ban_hai_san:latest
                    """
                }
            }
        }
    }
}
