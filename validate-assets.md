# Asset Validation Checklist

For each downloaded Lottie file:

## Technical
- [ ] Valid JSON format (parseable)
- [ ] File size < 200KB
- [ ] `"v": "5.7.4"` or compatible version
- [ ] `"fr": 30` or 60 (frame rate)
- [ ] `"ip": 0, "op": <duration>` (in/out points)
- [ ] `"w"` and `"h"` defined (dimensions)
- [ ] `"layers"` array present
- [ ] No `"assets"` with external references

## Visual
- [ ] Transparent background (no solid bg layer)
- [ ] Smooth loop (first frame ≈ last frame for looping)
- [ ] No watermarks / logos
- [ ] Color palette compatible (can tint via CSS filter)

## Legal
- [ ] License: Free for commercial use
- [ ] Attribution requirements noted
- [ ] Source URL documented

## Performance
- [ ] Tested on mobile (low-end device)
- [ ] No memory leaks on repeat play
- [ ] SVG renderer works (not canvas-only)