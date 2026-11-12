
import streamlit as st
import re
from datetime import datetime, date

st.set_page_config(
    page_title="Online Student Registration",
    page_icon="🎓",
    layout="centered"
)

# Page styling
st.markdown("""
<style>
.main {
    background-color: #f7f8fc;
}
.title {
    color: #263b70;
    font-size: 32px;
    font-weight: bold;
}
.subtitle {
    color: #64748b;
}
div.stButton > button {
    background-color: #3155a4;
    color: white;
    border-radius: 8px;
    width: 100%;
}
</style>
""", unsafe_allow_html=True)

st.markdown('<p class="title">🎓 Online Registration</p>',
            unsafe_allow_html=True)
st.markdown("### Student Portal")
st.markdown(
    '<p class="subtitle">Fill in your details to start your application.</p>',
    unsafe_allow_html=True
)

# Store successful registration
if "registration" not in st.session_state:
    st.session_state.registration = None

if st.session_state.registration:
    data = st.session_state.registration

    st.success("✓ Registration successful!")
    st.subheader("Application Details")

    st.write("**Full name:**", data["full_name"])
    st.write("**Email address:**", data["email"])
    st.write("**Phone number:**", data["phone"])
    st.write("**Date of birth:**", data["dob"])
    st.write("**Gender:**", data["gender"])
    st.write("**Course:**", data["course"])
    st.write("**Postal address:**", data["address"])

    if st.button("New Registration"):
        st.session_state.registration = None
        st.rerun()

else:
    errors = []

    with st.form("registration_form"):

        st.subheader("Start Your Application")

        full_name = st.text_input("Full Name *")
        email = st.text_input("Email Address *")
        phone = st.text_input("Phone Number *")
        dob = st.text_input("Date of Birth *", placeholder="YYYY-MM-DD")

        gender = st.selectbox(
            "Gender *",
            ["Choose an option", "Female", "Male",
             "Other", "Prefer not to say"]
        )

        course = st.selectbox(
            "Course Applying For *",
            ["Select a course", "BCA",
             "B.Sc. Computer Science", "B.Com",
             "BBA", "Other"]
        )

        address = st.text_area("Postal Address *")

        terms = st.checkbox(
            "I confirm that the information provided is correct."
        )

        st.caption(
            "Your information is used only for this demonstration."
        )

        submit = st.form_submit_button("Submit Application →")

    if submit:

        if not full_name.strip():
            errors.append("Full name is required.")

        if not re.fullmatch(
            r"[^@\s]+@[^@\s]+\.[^@\s]+", email.strip()
        ):
            errors.append("Enter a valid email address.")

        if not re.fullmatch(
            r"[0-9+\-\s()]{7,20}", phone.strip()
        ):
            errors.append("Enter a valid phone number.")

        try:
            birth_date = datetime.strptime(
                dob.strip(), "%Y-%m-%d"
            ).date()

            if birth_date > date.today():
                errors.append("Date of birth cannot be in the future.")

        except ValueError:
            errors.append("Enter date of birth in YYYY-MM-DD format.")

        if gender == "Choose an option":
            errors.append("Please select your gender.")

        if course == "Select a course":
            errors.append("Please select a course.")

        if not address.strip():
            errors.append("Address is required.")

        if not terms:
            errors.append("You must accept the declaration.")

        if errors:
            st.error("Please correct the following:")
            for error in errors:
                st.write("•", error)

        else:
            st.session_state.registration = {
                "full_name": full_name.strip(),
                "email": email.strip(),
                "phone": phone.strip(),
                "dob": dob.strip(),
                "gender": gender,
                "course": course,
                "address": address.strip()
            }
            st.rerun()

st.markdown("---")
st.caption("© 2026 Student Registration Portal · Demo Project")
