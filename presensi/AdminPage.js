// AdminPage.jsx — listing attendance records
import React, { useState, useEffect } from 'react';

export function AdminPage() {
  const [records, setRecords] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function fetchData() {
      setLoading(true);
      try {
        const resp = await fetch('/list_attendance.php');
        const data = await resp.json();
        if (resp.ok && Array.isArray(data.records)) {
          setRecords(data.records);
        } else {
          console.error('Bad data', data);
        }
      } catch (err) {
        console.error(err);
      } finally {
        setLoading(false);
      }
    }
    fetchData();
  }, []);

  function downloadCSV() {
    const header = 'Name,Timestamp,Lat,Lng,Photo\n';
    const rows = records.map(r => `${r.name},${r.timestamp_iso},${r.lat || ''},${r.lng || ''},${r.photo_path}`);
    const csv = header + rows.join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'attendance.csv';
    a.click();
    URL.revokeObjectURL(url);
  }

  if (loading) return <div>Loading...</div>;

  return (
    <div style={{ maxWidth: 900, margin: '24px auto', fontFamily: 'system-ui' }}>
      <h1>Attendance Records (Admin)</h1>
      <button onClick={downloadCSV}>Download CSV</button>
      <table style={{ width: '100%', borderCollapse: 'collapse', marginTop: 12 }}>
        <thead>
          <tr>
            <th style={{ border: '1px solid #ccc' }}>Name</th>
            <th style={{ border: '1px solid #ccc' }}>Timestamp</th>
            <th style={{ border: '1px solid #ccc' }}>Lat</th>
            <th style={{ border: '1px solid #ccc' }}>Lng</th>
            <th style={{ border: '1px solid #ccc' }}>Photo</th>
          </tr>
        </thead>
        <tbody>
          {records.map(r => (
            <tr key={r.id}>
              <td style={{ border: '1px solid #ccc' }}>{r.name}</td>
              <td style={{ border: '1px solid #ccc' }}>{r.timestamp_iso}</td>
              <td style={{ border: '1px solid #ccc' }}>{r.lat}</td>
              <td style={{ border: '1px solid #ccc' }}>{r.lng}</td>
              <td style={{ border: '1px solid #ccc' }}>
                <a href={`/${r.photo_path}`} target="_blank" rel="noreferrer">View</a>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}