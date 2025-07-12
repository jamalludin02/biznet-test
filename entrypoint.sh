#!/bin/bash

# Start Ollama service in background
ollama serve &

# Wait for Ollama to be ready
echo "Waiting for Ollama to start..."
sleep 10

# Check if model exists, if not pull it
echo "Checking for gemma3:1b model..."
if ! ollama list | grep -q "gemma3:1b"; then
    echo "Model gemma3:1b not found. Pulling..."
    ollama pull gemma3:1b
else
    echo "Model gemma3:1b already exists."
fi

# Keep container running
wait 