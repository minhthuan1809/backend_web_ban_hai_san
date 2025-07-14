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
                    echo "📝 Last commit message: ${commitMsg}"

                    // Build và chạy lại container
                    sh """
                        if docker ps -a --format '{{.Names}}' | grep -q '^web_ban_hai_san$'; then
                            echo "🛑 Dừng container cũ..."
                            docker stop web_ban_hai_san || true
                            docker rm web_ban_hai_san || true
                        fi

                        echo "🔨 Build image mới..."
                        docker build -t web_ban_hai_san:latest .

                        echo "🚀 Chạy lại container..."
                        docker run -d --name web_ban_hai_san -p 9999:9999 web_ban_hai_san:latest
                    """
                }
            }
        }
    }
}
