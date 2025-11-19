<?php
header("Content-Type: application/json");

// Check GET parameter
if (!isset($_GET['ai_message']) || empty($_GET['ai_message'])) {
    echo json_encode([
        "error" => "Missing GET parameter: ai_message"
    ]);
    exit;
}

// User message
$userMessage = $_GET['ai_message'];

// API endpoint
$url = "https://outerface.venice.ai/api/inference/chat";

// Request body
$payload = [
    "characterId" => "",
    "clientProcessingTime" => 3757,
    "conversationType" => "text",
    "includeVeniceSystemPrompt" => true,
    "isCharacter" => false,
    "modelId" => "zai-org-glm-4.6",
    "prompt" => [
        [
            "content" => $userMessage,
            "role" => "user"
        ]
    ],
    "reasoning" => true,
    "requestId" => "REQ_" . uniqid(),
    "systemPrompt" => "",
    "temperature" => 0.7,
    "topP" => 0.9,
    "userId" => "user_anon_1234568910",
    "webEnabled" => true
];

// cURL initialization
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
    CURLOPT_HTTPHEADER => [
        "User-Agent: Mozilla/5.0",
        "Content-Type: application/json",
        "x-venice-version: interface@20251119.005012+0a4e07f",
        "x-venice-timestamp: " . gmdate("Y-m-d\TH:i:s\Z"),
        "x-venice-locale: en"
    ],
    CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

// Handle errors
if ($error) {
    echo json_encode([
        "error" => "Curl Error: " . $error
    ]);
    exit;
}

// Output API JSON response
echo $response;