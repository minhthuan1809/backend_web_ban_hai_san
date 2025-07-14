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
                    
                    // Thay the docker-compose bang cac lenh Docker rieng le
                    // Gia dinh container ten la 'web_ban_hai_san'
                    sh '''
                        if docker ps -a | grep -q web_ban_hai_san; then
                            docker stop web_ban_hai_san || true
                            docker rm web_ban_hai_san || true
                        fi
                        docker build -t web_ban_hai_san:latest .
                        docker run -d --name web_ban_hai_san -p 9999:80 web_ban_hai_san:latest
                        
                        # Dam bao container da khoi dong
                        sleep 5
                        
                        # Kiem tra trang thai container
                        docker ps | grep web_ban_hai_san
                    '''
                }
            }
        }
    }
    
    post {
        success {
            echo "CI/CD pipeline thanh cong!"
        }
        failure {
            echo "CI/CD pipeline that bai!"
        }
    }
}
