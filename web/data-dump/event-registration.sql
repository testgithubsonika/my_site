--
-- PostgreSQL database dump
--

\restrict beJxIV0zMQ2pofH8wCuE3aIWYQcFd1wAoeffcS6PiUpoN2tK44cUJubItxIQRjw

-- Dumped from database version 16.11
-- Dumped by pg_dump version 16.11

-- Started on 2026-02-09 00:30:22

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 264 (class 1259 OID 31231)
-- Name: event_registration; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.event_registration (
    id integer NOT NULL,
    full_name character varying(255),
    email character varying(255),
    college_name character varying(255),
    department character varying(255),
    event_config_id integer NOT NULL,
    created integer NOT NULL
);


ALTER TABLE public.event_registration OWNER TO postgres;

--
-- TOC entry 5058 (class 0 OID 0)
-- Dependencies: 264
-- Name: TABLE event_registration; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.event_registration IS 'Stores event registrations';


--
-- TOC entry 263 (class 1259 OID 31230)
-- Name: event_registration_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.event_registration_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.event_registration_id_seq OWNER TO postgres;

--
-- TOC entry 5059 (class 0 OID 0)
-- Dependencies: 263
-- Name: event_registration_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.event_registration_id_seq OWNED BY public.event_registration.id;


--
-- TOC entry 4905 (class 2604 OID 31234)
-- Name: event_registration id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_registration ALTER COLUMN id SET DEFAULT nextval('public.event_registration_id_seq'::regclass);


--
-- TOC entry 5052 (class 0 OID 31231)
-- Dependencies: 264
-- Data for Name: event_registration; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.event_registration (id, full_name, email, college_name, department, event_config_id, created) FROM stdin;
1	Sonika Singh Tomar 	tomarsonika01@gmail.com	vit	cse	5	1770532524
2	Sonika	tomarsonika01@gmail.com	vit	cse	1	1770532609
3	Soni	tomarsonika81@gmail.com	vit	cse	2	1770532810
4	Soni	tomarsonika10@gmail.com	vit	cse	5	1770536225
5	tanisha	tomarsonik@gmail.com	vit	cse	3	1770540772
6	tanisha	tomarsonika01@gmail.com	vit	computer science 	4	1770550978
7	avisha sahu	sonika.23@vitbhopal.ac.in	vitbpl	EEE	7	1770551233
8	Sonika	sonika.23bce10041@vitbhopal.ac	Son	Sonika	5	1770557363
9	Sonika	sonika.23bce10041@vitbhopal.ac.in	Son	Sonika	4	1770570846
10	Sonika	sonika.23bce10041@vitbhopal.ac.in	Son	Sonika	5	1770571079
\.


--
-- TOC entry 5060 (class 0 OID 0)
-- Dependencies: 263
-- Name: event_registration_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.event_registration_id_seq', 10, true);


--
-- TOC entry 4907 (class 2606 OID 31238)
-- Name: event_registration event_registration____pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_registration
    ADD CONSTRAINT event_registration____pkey PRIMARY KEY (id);


-- Completed on 2026-02-09 00:30:22

--
-- PostgreSQL database dump complete
--

\unrestrict beJxIV0zMQ2pofH8wCuE3aIWYQcFd1wAoeffcS6PiUpoN2tK44cUJubItxIQRjw

