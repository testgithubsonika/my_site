# Event Registration Module - Modern Form Styling Guide

## Overview

This module now features modern, professional form styling inspired by e-commerce platforms like Flipkart. The styling provides an excellent user experience with clean design, smooth interactions, and responsive layouts.

## 🎨 Key Features

### Design Principles
- **Modern & Clean**: Minimalist design with ample whitespace
- **Accessible**: WCAG compliant with proper contrast and focus states
- **Responsive**: Works perfectly on desktop, tablet, and mobile devices
- **Interactive**: Smooth transitions and hover effects
- **Professional**: Card-based design with subtle shadows

### Color Scheme
- **Primary Color**: `#0074bd` (Professional Blue) - Used for buttons, focus states, and highlights
- **Success**: `#4caf50` (Green) - For success messages
- **Error**: `#f44336` (Red) - For error messages and validation
- **Warning**: `#ff9800` (Orange) - For warning messages
- **Background**: `#f5f5f5` (Light Gray) - Secondary background
- **Border**: `#e0e0e0` (Subtle Gray) - Form borders

## 📋 Styling Applied to Forms

### 1. **Event Registration Form** (`/event-registration`)
Modern registration form with:
- Smooth input field focus effects with blue glow
- Category → Event Date → Event Name cascading dropdowns
- Clear participant detail grouping
- Responsive two-column layout on desktop
- Full-width inputs on mobile
- Validation error styling (red borders + helpful messages)

**Key Elements:**
```php
// Attach library in buildForm():
$form['#attached']['library'][] = 'event_registration/form_styles';
```

### 2. **Event Configuration Form** (`/admin/event-registration/config`)
Admin form for creating/editing events with:
- Large input fields with proper spacing
- Date pickers with modern styling
- Category selector with dropdown arrow
- Clean form layout with subtle gradient background
- Submit button with hover effects

**Features:**
- Event Name input
- Category dropdown
- Registration dates (start & end)
- Event Date picker
- Form validation

### 3. **Event Admin Dashboard** (`/admin/event-registration/dashboard`)
Filter and display form with:
- Modern card-based layout
- Event date and event name filters
- Cascading dropdowns
- Analytics cards showing statistics
- Clean table with hover effects

## 🎯 CSS Features Implemented

### Input Fields
```css
- Focus state with blue glow (3px shadow)
- Hover effects
- Error state styling (red border + light red background)
- Disabled state with reduced opacity
- Smooth transitions
- Custom select dropdown styling
```

### Buttons
```css
Primary Button (Submit):
- Blue background (#0074bd)
- White text
- Subtle shadow
- Hover: Lighter blue + lifted effect
- Active: Pressed effect

Secondary Button (Reset):
- Light gray background
- Gray text + border
- Hover: Blue text + border
```

### Form Layout
```css
- Max-width: 800px (centered)
- Card-based sections with 8px border-radius
- Consistent padding: 12-24px
- Proper spacing between form items: 20px
- Two-column layout on desktop (15px gap)
- Single column on mobile
```

### Responsive Breakpoints
- **Desktop**: Full 2-column layout, 800px max width
- **Tablet** (≤768px): Single column, adjusted padding
- **Mobile** (≤480px): Full-width inputs, larger touch targets (44px minimum)

## 🎨 Customization Guide

### Change Primary Color
Edit `:root` variables in `css/forms.css`:

```css
:root {
  --primary-color: #0074bd;      /* Change this */
  --primary-light: #1e88e5;      /* Change this */
  /* ... other colors ... */
}
```

### Adjust Form Max Width
```css
.custom-form {
  max-width: 800px;  /* Change this value */
  margin: 20px auto;
  padding: 0;
}
```

### Modify Input Padding
```css
input[type="text"],
input[type="email"],
/* ... etc ... */ {
  padding: 12px 14px;  /* Adjust padding */
}
```

### Change Button Text Transform
```css
button, input[type="submit"], .button {
  text-transform: uppercase;  /* Change to 'none' for normal casing */
}
```

## 📱 Mobile-First Responsive Tips

### Add Custom Breakpoint
```css
/* Extra small phones */
@media (max-width: 360px) {
  .custom-form {
    margin: 5px;
    padding: 0 5px;
  }
}

/* Large screens */
@media (min-width: 1200px) {
  .custom-form {
    max-width: 900px;
  }
}
```

## 🔧 Advanced Styling

### Use CSS Custom Properties
All colors are defined as CSS variables, making it easy to create themes:

```css
/* Light theme (default) */
:root {
  --primary-color: #0074bd;
  --bg-light: #f5f5f5;
  --text-primary: #212121;
}

/* Dark theme example */
@media (prefers-color-scheme: dark) {
  :root {
    --primary-color: #64b5f6;
    --bg-light: #424242;
    --text-primary: #ffffff;
  }
}
```

### Add Custom Form Sections
```css
.custom-fieldset {
  background: white;
  border-radius: 8px;
  padding: 24px;
  margin-bottom: 20px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.08);
  border-left: 4px solid var(--primary-color);
}
```

## 🎬 Animation Classes

### Loading Spinner
```html
<div class="ajax-progress">
  <div class="throbber"></div>
  Loading...
</div>
```

### Message Animation
Messages slide down smoothly when displayed (0.3s animation).

## ♿ Accessibility Features

### Keyboard Navigation
- All form elements are fully keyboard accessible
- Tab order follows visual order
- Enter key triggers form submission
- Space/Enter activates buttons

### Color Contrast
- Text: 4.5:1 contrast ratio (WCAG AA)
- Focus indicators: 3px outline visible

### Screen Reader Support
- Proper label associations
- Error messages linked to inputs via `aria-invalid`
- Form sections clearly marked

### Form Hints
```php
$form['field'] = [
  '#type' => 'textfield',
  '#title' => 'Field Name',
  '#description' => 'This appears as help text',  // Screen reader + visible
  '#required' => TRUE,  // Shows red asterisk
];
```

## 🚀 Best Practices

### 1. **Use Proper Form IDs**
```php
public function getFormId() {
  return 'my_custom_form';  // Used for styling: #my_custom_form
}
```

### 2. **Group Related Fields**
```php
// Use fieldsets for organization
$form['section_name'] = [
  '#type' => 'fieldset',
  '#title' => 'Section Title',
];
```

### 3. **Add Help Text**
```php
'#description' => 'Help text that guides users',
'#required' => TRUE,  // Shows required indicator
```

### 4. **Provide Clear Feedback**
```php
// In validateForm()
$form_state->setErrorByName('field_name', 'Explain what went wrong');

// In submitForm()
$this->messenger()->addMessage('Success message here');
```

### 5. **Mobile-Friendly Input Types**
```php
// Use proper types for mobile optimization
$form['email'] = ['#type' => 'email'];        // Shows email keyboard
$form['date'] = ['#type' => 'date'];          // Shows date picker
$form['phone'] = ['#type' => 'tel'];          // Shows phone keyboard
$form['url'] = ['#type' => 'url'];            // Shows URL keyboard
```

## 📊 Form Examples

### Multi-Column Layout
```php
$form['row1'] = [
  '#prefix' => '<div class="form-row">',
  '#suffix' => '</div>',
];

$form['row1']['field1'] = [/* ... */];
$form['row1']['field2'] = [/* ... */];
```

### Form Progress Indicator
```html
<div class="form-progress">
  <div class="progress-step completed"></div>
  <div class="progress-step active"></div>
  <div class="progress-step"></div>
</div>
```

## 🔍 Troubleshooting

### Styles Not Showing
1. Clear Drupal cache: `drush cache-rebuild`
2. Check if library is attached: `$form['#attached']['library'][] = 'event_registration/form_styles';`
3. Verify CSS file exists: `web/modules/custom/event_registration/css/forms.css`

### AJAX Interactions Not Working
- Ensure form callbacks return correct AJAX wrapper elements
- Check browser console for JavaScript errors
- Verify AJAX wrappers match between form definition and callback

### Mobile Layout Issues
- Test with Chrome DevTools responsive mode
- Check viewport meta tag in HTML head
- Verify CSS media queries are defined

## 📚 File Structure

```
event_registration/
├── css/
│   ├── dashboard.css      (Dashboard-specific styles)
│   └── forms.css          (All form styling - NEW)
├── src/
│   └── Form/
│       ├── EventConfigForm.php        (With library attachment)
│       ├── EventRegistrationForm.php  (With library attachment)
│       └── AdminSettingsForm.php      (With library attachment)
└── event_registration.libraries.yml   (Updated with form_styles)
```

## 🎓 Learning Resources

### Color Theory
- Use color psychology to guide user emotions
- Primary: Professional blue for trust
- Green: Success and positive actions
- Red: Warnings and errors

### Typography
- Font stack: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
- Body: 14px | Headers: 16-18px
- Line height: 1.4-1.6 for readability

### Spacing (8px Grid System)
- Padding: 8px, 12px, 16px, 20px, 24px, 28px, 32px
- Margins: 8px, 12px, 16px, 20px
- Gaps: 10px, 15px, 20px, 25px

## ✨ Future Enhancements

Consider adding:
- [ ] Dark mode toggle
- [ ] Form field animations
- [ ] Loading state overlays
- [ ] Success checkmarks
- [ ] Inline validation
- [ ] Auto-save indicators
- [ ] Captcha styling
- [ ] Progress bars for long forms

---

**Last Updated**: February 8, 2026  
**Version**: 1.0  
**Module**: Event Registration  
**Drupal Version**: 9+
