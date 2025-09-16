// ReactAttendance.jsx — single-file React component for capturing & uploading photo
// and AdminPage.jsx — simple admin page listing attendance records.

import React, { useState, useRef, useEffect } from 'react';

export default function ReactAttendance() {
  const [status, setStatus] = useState('idle');
  const [name, setName] = useState('');
  const [preview, setPreview] = useState(null);
  const videoRef = useRef(null);
  const canvasRef = useRef(null);
  const [stream, setStream] = useState(null);

  async function startCamera() {
    try {
      const s = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
      videoRef.current.srcObject = s;
      setStream(s);
      setStatus('camera started');
    } catch (err) {
      console.error(err);
      setStatus('camera error: ' + err.message);
    }
  }

  function stopCamera() {
    if (stream) {
      stream.getTracks().forEach(t => t.stop());
      videoRef.current.srcObject = null;
      setStream(null);
      setStatus('camera stopped');
    }
  }

  function getTimestamp() {
    return new Date().toISOString();
  }

  function captureToBlob() {
    const video = videoRef.current;
    const canvas = canvasRef.current;
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    return new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.85));
  }

  async function uploadAttendance() {
    if (!stream) {
      alert('Camera is not started');
      return;
    }
    if (!name.trim()) {
      alert('Please enter Name or ID');
      return;
    }
    setStatus('capturing photo...');
    const blob = await captureToBlob();
    const timestamp = getTimestamp();
    let lat = null, lng = null;
    try {
      const pos = await new Promise((res, rej) => {
        navigator.geolocation.getCurrentPosition(res, rej, { timeout: 5000 });
      });
      lat = pos.coords.latitude;
      lng = pos.coords.longitude;
    } catch (e) {
      console.warn('geolocation not available or denied', e);
    }

    const fd = new FormData();
    fd.append('name', name.trim());
    fd.append('timestamp', timestamp);
    if (lat !== null) fd.append('lat', lat);
    if (lng !== null) fd.append('lng', lng);
    fd.append('photo', blob, `photo_${Date.now()}.jpg`);

    setStatus('uploading...');
    try {
      const resp = await fetch('/upload.php', { method: 'POST', body: fd });
      const data = await resp.json();
      if (resp.ok && data.success) {
        setStatus('uploaded ✓');
        const imgUrl = URL.createObjectURL(blob);
        setPreview({ src: imgUrl, meta: `Name: ${name} — ${timestamp}` });
      } else {
        setStatus('upload failed');
        alert('Upload failed: ' + (data?.error || resp.statusText));
      }
    } catch (err) {
      console.error(err);
      setStatus('upload error');
      alert('Upload error: ' + err.message);
    }
  }

  return (
    <div style={{ maxWidth: 900, margin: '24px auto', fontFamily: 'system-ui' }}>
      <h1>Online Attendance (React)</h1>
      <label>
        Name or NIP:&nbsp;
        <input value={name} onChange={e => setName(e.target.value)} placeholder="Your name or ID" />
      </label>
      <div style={{ marginTop: 12 }}>
        <video ref={videoRef} autoPlay playsInline style={{ width: '100%', maxWidth: 480, borderRadius: 8, background: '#000' }} />
        <canvas ref={canvasRef} style={{ display: 'none' }} />
      </div>
      <div style={{ marginTop: 12, display: 'flex', gap: 8 }}>
        <button onClick={startCamera} disabled={stream}>Start Camera</button>
        <button onClick={uploadAttendance} disabled={!stream}>Capture & Upload</button>
        <button onClick={stopCamera} disabled={!stream}>Stop Camera</button>
      </div>
      <div style={{ marginTop: 8, color: '#444' }}>Status: {status}</div>
      {preview && (
        <div style={{ marginTop: 12 }}>
          <img src={preview.src} alt="preview" style={{ maxWidth: 200, borderRadius: 6, display: 'block' }} />
          <small>{preview.meta}</small>
        </div>
      )}
    </div>
  );
}