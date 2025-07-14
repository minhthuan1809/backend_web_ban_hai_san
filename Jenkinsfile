pipeline {
    agent any
    environment {
        PATH = "/usr/local/bin:/usr/bin:${PATH}"
        ENVIRONMENT = "PRODUCTION"
        DB_HOST = "42.96.16.211"
        DB_USER = "root"
        DB_PASS = "Thuan18092003"
        DB_NAME = "haisan"
        DB_PORT = "3306"
    }
    stages {
        stage("Build") {
            steps {
                script {
                    sh "echo 'Bắt đầu build Docker image'"
                    sh "docker build -t web_ban_hai_san:latest ."
                    sh "echo 'Build Docker image thành công'"
                }
            }
        }
        
        stage("Deploy") {
            steps {
                script {
                    try {
                        sh """
                            echo 'Đang dừng và xóa container cũ nếu có...'
                            if docker ps -a | grep -q web_ban_hai_san; then
                                docker stop web_ban_hai_san || true
                                docker rm web_ban_hai_san || true
                            fi
                            
                            echo 'Tạo Docker network nếu chưa tồn tại...'
                            docker network inspect haisan_network >/dev/null 2>&1 || docker network create haisan_network
                            
                            echo 'Khởi chạy container mới...'
                            docker run -d --name web_ban_hai_san \
                                -p 9999:80 \
                                -e DB_HOST=${DB_HOST} \
                                -e DB_USER=${DB_USER} \
                                -e DB_PASS=${DB_PASS} \
                                -e DB_NAME=${DB_NAME} \
                                -e DB_PORT=${DB_PORT} \
                                --network haisan_network \
                                --restart unless-stopped \
                                web_ban_hai_san:latest
                            
                            sleep 5
                            echo 'Kiểm tra trạng thái container...'
                            docker ps | grep web_ban_hai_san
                            
                            if [ \$? -ne 0 ]; then
                                echo 'Container không chạy, kiểm tra logs...'
                                docker logs web_ban_hai_san
                                exit 1
                            fi
                            
                            echo 'Deploy hoàn tất thành công!'
                        """
                    } catch (Exception e) {
                        echo "Deploy thất bại: ${e.getMessage()}"
                        currentBuild.result = 'FAILURE'
                        error "Deploy thất bại: ${e.getMessage()}"
                    }
                }
            }
        }
    }
    
    post {
        success {
            echo "CI/CD pipeline thành công!"
        }
        failure {
            echo "CI/CD pipeline thất bại!"
        }
    }
}
