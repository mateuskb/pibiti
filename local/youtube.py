import googleapiclient.discovery
import googleapiclient.errors
import google_auth_oauthlib.flow

api_key = 'AIzaSyDCk4g1gbYJM6fOELD09QvldQhKykKBVcM'
login_code = '4/vwHpdPlMhTjPSdKD06LDEImbkEfOUrHwwegW9_1UP-8Vf6rO9O71HeY'
scopes = ["https://www.googleapis.com/auth/youtube"]
client_secrets_file = "client_secret.json"

flow = google_auth_oauthlib.flow.InstalledAppFlow.from_client_secrets_file(
    client_secrets_file, scopes)
credentials = flow.run_console()

youtube = googleapiclient.discovery.build(
        'youtube', 'v3', credentials=credentials)

request = youtube.liveBroadcasts().insert(
    part="snippet,contentDetails,status",
    body={
        "contentDetails": {
            "enableClosedCaptions": True,
            "enableContentEncryption": True,
            "enableDvr": True,
            "enableEmbed": True,
            "recordFromStart": True,
            "startWithSlate": True
          },
          "snippet": {
            "title": "Test broadcast",
            "scheduledStartTime": "2020-01-31T15:20:30.45+03:00"
            #"scheduledEndTime": "YOUR_SCHEDULED_END_TIME"
          },
          "status": {
            "privacyStatus": "unlisted"
          }
        }
)
response = request.execute()

print(response)