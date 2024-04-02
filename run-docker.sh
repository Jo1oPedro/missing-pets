#!/bin/bash

# Set the paths to your Docker Compose files and .env file
dockerComposeFiles=("docker-compose.yaml" "docker-compose.dev.yaml")
envFile=".env"

# Construct the Docker Compose command
dockerComposeCommand="docker compose"
dockerComposeArguments=()
for file in "${dockerComposeFiles[@]}"; do
    dockerComposeArguments+=("-f" "$file")
done
dockerComposeArguments+=("up" "--build" "-d")

echo "$dockerComposeCommand ${dockerComposeArguments[@]}"

# Run the Docker Compose command
"$dockerComposeCommand" "${dockerComposeArguments[@]}"
