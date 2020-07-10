# Source: https://stackoverflow.com/a/43317244
$path = "C:\Users\toshiba\Videos\food\orderam.pem"
# Reset to remove explict permissions
icacls.exe $path /reset
# Give current user explicit read-permission
icacls.exe $path /GRANT:R "$($env:USERNAME):(R)"
# Disable inheritance and remove inherited permissions
icacls.exe $path /inheritance:r

# ssh -i orderam.pem ec2-user@ec2-18-222-94-201.us-east-2.compute.amazonaws.com

orderamPassword