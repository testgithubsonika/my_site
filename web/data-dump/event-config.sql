--
-- PostgreSQL database dump
--

\restrict qweGL1kfoEco4nxc6fC3TC9Y4IXshD4y6QRtlKzU7aZ9qKqnIWGNT8sPe2lTdxf

-- Dumped from database version 16.11
-- Dumped by pg_dump version 16.11

-- Started on 2026-02-09 00:29:33

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
-- TOC entry 262 (class 1259 OID 31224)
-- Name: event_config; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.event_config (
    id integer NOT NULL,
    event_name character varying(255) NOT NULL,
    category character varying(100) NOT NULL,
    registration_start integer NOT NULL,
    registration_end integer NOT NULL,
    event_date integer NOT NULL,
    created integer NOT NULL
);


ALTER TABLE public.event_config OWNER TO postgres;

--
-- TOC entry 5058 (class 0 OID 0)
-- Dependencies: 262
-- Name: TABLE event_config; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.event_config IS 'Stores event configuration';


--
-- TOC entry 261 (class 1259 OID 31223)
-- Name: event_config_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.event_config_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.event_config_id_seq OWNER TO postgres;

--
-- TOC entry 5059 (class 0 OID 0)
-- Dependencies: 261
-- Name: event_config_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.event_config_id_seq OWNED BY public.event_config.id;


--
-- TOC entry 4905 (class 2604 OID 31227)
-- Name: event_config id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_config ALTER COLUMN id SET DEFAULT nextval('public.event_config_id_seq'::regclass);


--
-- TOC entry 5052 (class 0 OID 31224)
-- Dependencies: 262
-- Data for Name: event_config; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.event_config (id, event_name, category, registration_start, registration_end, event_date, created) FROM stdin;
1	advitya	online	1770229800	1770661800	1770489000	1770393613
2	sonika	hackathon	1770316200	1770834600	1770834600	1770394378
3	sikha	online	1770316200	1770921000	1770921000	1770394806
4	singh	online	1770229800	1770661800	1770748200	1770394833
5	sss	conference	1770489000	1770661800	1770748200	1770527686
6	hog	one_day	1770489000	1771180200	1771266600	1770548605
7	blazerss	hackathon	1770489000	1771353000	1771612200	1770551159
8	soni***	online	1770489000	1771007400	1771785000	1770554853
\.


--
-- TOC entry 5060 (class 0 OID 0)
-- Dependencies: 261
-- Name: event_config_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.event_config_id_seq', 8, true);


--
-- TOC entry 4907 (class 2606 OID 31229)
-- Name: event_config event_config____pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_config
    ADD CONSTRAINT event_config____pkey PRIMARY KEY (id);


-- Completed on 2026-02-09 00:29:34

--
-- PostgreSQL database dump complete
--

\unrestrict qweGL1kfoEco4nxc6fC3TC9Y4IXshD4y6QRtlKzU7aZ9qKqnIWGNT8sPe2lTdxf

