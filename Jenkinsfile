node {
    try {
        slackSend channel: '#joomlashacktemplates', message: "${env.JOB_NAME} #${env.BUILD_NUMBER}. Triggering update on a set of templates..."

        stage('Civic') {
            build 'JoomlaShack-Templates/Civic-Wright'
        }

        stage('Travertine') {
            build 'JoomlaShack-Templates/Travertine-Wright'
        }
        
        stage('Clementine') {
            build 'JoomlaShack-Templates/Clementine-Wright'
        }
        
        stage('Community') {
            build 'JoomlaShack-Templates/Community-Wright'
        }
        
        stage('Alasse') {
            build 'JoomlaShack-Templates/Alasse-Wright'
        }
        
        stage('Flow') {
            build 'JoomlaShack-Templates/Flow-Wright'
        }
        
        stage('Wylia2') {
            build 'JoomlaShack-Templates/Wylia2-Wright'
        }
        
        stage('Unlimited') {
            build 'JoomlaShack-Templates/Unlimited-Wright'
        }
        
        stage('Tripod') {
            build 'JoomlaShack-Templates/Tripod-Wright'
        }
        
        stage('Novitas') {
            build 'JoomlaShack-Templates/Novitas-Wright'
        }
       

        slackSend channel: '#joomlashacktemplates', color: 'good', message: "${env.JOB_NAME} #${env.BUILD_NUMBER}. Finished"
    } catch (e) {
        slackSend channel: '#joomlashacktemplates', color: 'danger', message: "${env.JOB_NAME} #${env.BUILD_NUMBER} FAILED"
        // Force a failure
        sh "exit 1" 
    }
}
