node {
    try {
        slackSend channel: '#joomlashacktemplates', message: "${env.JOB_NAME} #${env.BUILD_NUMBER}. Triggering update on a set of templates..."

        stage('Civic') {
            build 'JoomlaShack-Templates/Civic-Wright'
        }

        stage('Travertine') {
            build 'JoomlaShack-Templates/Travertine-Wright'
        }

        slackSend channel: '#joomlashacktemplates', color: 'good', message: "${env.JOB_NAME} #${env.BUILD_NUMBER}. Finished"
    } catch (e) {
        slackSend channel: '#joomlashacktemplates', color: 'danger', message: "${env.JOB_NAME} #${env.BUILD_NUMBER} FAILED"
        // Force a failure
        sh "exit 1" 
    }
}
